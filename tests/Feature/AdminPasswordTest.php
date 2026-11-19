<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_change_own_password_and_login_with_it(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $other = User::factory()->create(['is_admin' => true]);
        $otherHash = $other->password;
        $oldToken = $admin->remember_token;

        $this->actingAs($admin)->get(route('admin.password.edit'))
            ->assertOk()->assertSee('Password lama')->assertSee('Konfirmasi password baru');

        $this->put(route('admin.password.update'), [
            'current_password' => 'password',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
            'user_id' => $other->id,
        ])->assertRedirect(route('admin.password.edit'))->assertSessionHas('status');

        $this->assertTrue(Hash::check('new-password-123', $admin->fresh()->password));
        $this->assertNotSame($oldToken, $admin->fresh()->remember_token);
        $this->assertSame($otherHash, $other->fresh()->password);
        $this->assertAuthenticatedAs($admin);

        $this->post(route('admin.logout'));
        $this->post(route('admin.login.store'), ['email' => $admin->email, 'password' => 'password'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->post(route('admin.login.store'), ['email' => $admin->email, 'password' => 'new-password-123'])
            ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    #[DataProvider('invalidPasswords')]
    public function test_invalid_password_changes_are_rejected(array $input, string $error): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $hash = $admin->password;

        $this->actingAs($admin)->from(route('admin.password.edit'))
            ->put(route('admin.password.update'), $input)
            ->assertRedirect(route('admin.password.edit'))
            ->assertSessionHasErrors($error)
            ->assertSessionMissing('_old_input.current_password')
            ->assertSessionMissing('_old_input.password')
            ->assertSessionMissing('_old_input.password_confirmation');

        $this->assertSame($hash, $admin->fresh()->password);
    }

    public static function invalidPasswords(): array
    {
        $valid = ['current_password' => 'password', 'password' => 'new-password-123', 'password_confirmation' => 'new-password-123'];

        return [
            'wrong current password' => [[...$valid, 'current_password' => 'wrong'], 'current_password'],
            'missing current password' => [[...$valid, 'current_password' => ''], 'current_password'],
            'missing new password' => [[...$valid, 'password' => ''], 'password'],
            'too short' => [[...$valid, 'password' => 'short', 'password_confirmation' => 'short'], 'password'],
            'too long' => [[...$valid, 'password' => str_repeat('a', 73), 'password_confirmation' => str_repeat('a', 73)], 'password'],
            'mismatched confirmation' => [[...$valid, 'password_confirmation' => 'different-password'], 'password'],
            'unchanged password' => [[...$valid, 'password' => 'password', 'password_confirmation' => 'password'], 'password'],
        ];
    }

    public function test_guests_cannot_access_password_routes(): void
    {
        $this->get(route('admin.password.edit'))->assertRedirect(route('admin.login'));
        $this->put(route('admin.password.update'), [])->assertRedirect(route('admin.login'));
    }

    public function test_regular_users_cannot_access_password_routes(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('admin.password.edit'))->assertForbidden();
        $this->put(route('admin.password.update'), [])->assertForbidden();
    }

    public function test_password_attempts_are_rate_limited(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->put(route('admin.password.update'), [])->assertSessionHasErrors();
        }

        $this->put(route('admin.password.update'), [])->assertStatus(429);
    }
}
