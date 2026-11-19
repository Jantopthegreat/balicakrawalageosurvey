<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPasswordResetController extends Controller
{
    public function create(): View
    {
        return view('admin.password-recovery', ['reset' => false]);
    }

    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate(['email' => ['required', 'email', 'max:255']], [
            'email.required' => 'Masukkan email akun admin.',
            'email.email' => 'Masukkan alamat email yang valid.',
        ]);

        Password::broker('users')->sendResetLink([...$validated, 'is_admin' => true]);

        return back()->with('status', 'Jika email terdaftar sebagai admin, tautan reset password akan dikirim. Periksa kotak masuk dan folder spam. Tunggu satu menit sebelum meminta tautan lagi.');
    }

    public function edit(Request $request, string $token): View
    {
        return view('admin.password-recovery', [
            'reset' => true,
            'token' => $token,
            'email' => is_string($request->query('email')) ? $request->query('email') : '',
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
        ], [
            'token.required' => 'Tautan reset tidak valid. Silakan minta tautan baru.',
            'email.required' => 'Masukkan email akun admin.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'password.required' => 'Masukkan password baru.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.max' => 'Password baru maksimal 72 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $status = Password::broker('users')->reset([...$validated, 'is_admin' => true], function (User $user, string $password): void {
            $user->forceFill(['password' => $password, 'remember_token' => Str::random(60)])->save();

            if (config('session.driver') === 'database') {
                DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $user->id)->delete();
            }

            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors(['email' => 'Tautan reset tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.'])->onlyInput('email');
        }

        return redirect()->route('admin.login')->with('status', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}
