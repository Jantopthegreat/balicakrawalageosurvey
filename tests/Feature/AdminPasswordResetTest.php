<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\AdminResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AdminPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_recovery_pages_are_accessible_and_linked_from_login(): void
    {
        $this->get(route('admin.login'))->assertOk()->assertSee(route('admin.password.request'));
        $this->get(route('admin.password.request'))->assertOk()->assertSee('Kirim Tautan Reset');
        $this->get(route('admin.password.reset', ['token' => 'example', 'email' => 'admin@example.com']))
            ->assertOk()->assertSee('admin@example.com')->assertSee('Konfirmasi password baru');
    }

    public function test_only_admins_receive_reset_email_without_disclosing_account_existence(): void
    {
        Notification::fake();
        $admin = User::factory()->create(['is_admin' => true]);
        $regular = User::factory()->create();

        $this->post(route('admin.password.email'), ['email' => $admin->email])->assertSessionHas('status');
        $message = session('status');
        Notification::assertSentTo($admin, AdminResetPassword::class, function ($notification) use ($admin) {
            $mail = $notification->toMail($admin);
            $this->assertSame(route('admin.password.reset', ['token' => $notification->token, 'email' => $admin->email]), $mail->actionUrl);
            $this->assertTrue(Password::broker('users')->tokenExists($admin, $notification->token));
            $this->assertStringContainsString('Reset Password', $mail->render());

            return true;
        });

        foreach ([$regular->email, 'missing@example.com', $admin->email] as $email) {
            $this->post(route('admin.password.email'), ['email' => $email])->assertSessionHas('status', $message);
        }
        Notification::assertCount(1);
    }

    public function test_reset_changes_password_revokes_sessions_and_consumes_token(): void
    {
        config(['session.driver' => 'database']);
        $admin = User::factory()->create(['is_admin' => true]);
        $oldToken = $admin->remember_token;
        \Illuminate\Support\Facades\DB::table('sessions')->insert([
            'id' => 'old-admin-session', 'user_id' => $admin->id, 'payload' => '', 'last_activity' => time(),
        ]);
        $token = Password::broker('users')->createToken($admin);
        $input = ['email' => $admin->email, 'token' => $token, 'password' => 'new-password-123', 'password_confirmation' => 'new-password-123'];

        $this->post(route('admin.password.reset.store'), $input)->assertRedirect(route('admin.login'))->assertSessionHas('status');
        $this->assertTrue(Hash::check($input['password'], $admin->fresh()->password));
        $this->assertNotSame($oldToken, $admin->fresh()->remember_token);
        $this->assertDatabaseMissing('sessions', ['id' => 'old-admin-session']);
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $admin->email]);
        $this->assertGuest();
        $this->post(route('admin.password.reset.store'), $input)->assertSessionHasErrors('email');
        $this->post(route('admin.login.store'), ['email' => $admin->email, 'password' => $input['password']])
            ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_invalid_expired_or_other_users_token_cannot_reset_password(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $other = User::factory()->create(['is_admin' => true]);
        $oldHash = $admin->password;
        $token = Password::broker('users')->createToken($admin);

        foreach (['invalid', Password::broker('users')->createToken($other)] as $badToken) {
            $this->post(route('admin.password.reset.store'), [
                'email' => $admin->email, 'token' => $badToken,
                'password' => 'new-password-123', 'password_confirmation' => 'new-password-123',
            ])->assertSessionHasErrors('email');
        }
        $this->travel(61)->minutes();
        $this->post(route('admin.password.reset.store'), [
            'email' => $admin->email, 'token' => $token,
            'password' => 'new-password-123', 'password_confirmation' => 'new-password-123',
        ])->assertSessionHasErrors('email');
        $this->assertSame($oldHash, $admin->fresh()->password);
    }

    public function test_regular_users_cannot_reset_even_with_a_valid_token(): void
    {
        $user = User::factory()->create();
        $hash = $user->password;
        $this->post(route('admin.password.reset.store'), [
            'email' => $user->email, 'token' => Password::broker('users')->createToken($user),
            'password' => 'new-password-123', 'password_confirmation' => 'new-password-123',
        ])->assertSessionHasErrors('email');
        $this->assertSame($hash, $user->fresh()->password);
    }

    public function test_password_validation_does_not_consume_token_or_flash_password(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $token = Password::broker('users')->createToken($admin);
        foreach ([['short', 'short'], ['new-password-123', 'mismatch']] as [$password, $confirmation]) {
            $this->post(route('admin.password.reset.store'), [
                'email' => $admin->email, 'token' => $token, 'password' => $password, 'password_confirmation' => $confirmation,
            ])->assertSessionHasErrors('password')->assertSessionMissing('_old_input.password');
        }
        $this->assertTrue(Password::broker('users')->tokenExists($admin, $token));
        $this->assertTrue(Hash::check('password', $admin->fresh()->password));
    }

    public function test_reset_email_requests_are_rate_limited(): void
    {
        Notification::fake();
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('admin.password.email'), ['email' => 'missing@example.com'])->assertSessionHas('status');
        }
        $this->post(route('admin.password.email'), ['email' => 'missing@example.com'])->assertStatus(429);
    }
}
