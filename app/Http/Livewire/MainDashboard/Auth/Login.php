<?php

namespace App\Http\Livewire\MainDashboard\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{
    use AuthenticatesUsers, LivewireAlert;

    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public bool $show2FA = false;

    public bool $showEmailOTP = false;

    public string $totp_code = '';

    public string $email_otp_code = '';

    protected function getRules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            'remember' => 'nullable',
            'totp_code' => 'nullable|string',
            'email_otp_code' => 'nullable|string',
        ];
    }

    public function login()
    {
        // validate
        $validation = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
        $this->validate($validation);

        $user = \App\Models\User::where('email', $this->email)->first();

        if ($user && \Hash::check($this->password, $user->password)) {
            // Bypass OTP/TOTP if there is already an active session
            if (Auth::guard('dashboard')->check() || Auth::guard('web')->check()) {
                Auth::guard('dashboard')->login($user, $this->remember);
                return redirect()->intended('/');
            }

            if ($user->google2fa_enabled && $user->google2fa_secret) {
                session([
                    '2fa:user_id' => $user->id,
                    '2fa:remember' => $this->remember,
                ]);
                $this->show2FA = true;

                return;
            }

            // Fallback to Email OTP
            $otp = rand(100000, 999999);

            // Save OTP to users table
            $user->email_otp = $otp;
            $user->email_otp_expires_at = now()->addMinutes(10);
            $user->save();

            session([
                '2fa:user_id' => $user->id,
                '2fa:remember' => $this->remember,
            ]);

            try {
                $body = view('emails.otp', ['otp' => $otp])->render();
                // $send = sendPowerAutomateEmail([
                //     'SendTo' => $user->email,
                //     'Title' => 'Kode OTP Login AIMS - ' . $otp,
                //     'MsgBody' => $body,
                //     'AttchmentPath' => '',
                //     'AttchmentName' => '',
                //     'SendCC' => '',
                //     'Key' => '!234$'
                // ]);

                // if (isset($send['status']) && $send['status'] === 'error') {
                //     throw new \Exception($send['message']);
                // }
            } catch (\Exception $e) {
                \Log::error('Gagal mengirimkan OTP ke email: '.$e->getMessage());
                if (config('app.env') === 'local') {
                    \Log::info("LOCAL DEV BYPASS: OTP for {$user->email} is {$otp}");
                    session()->flash('error', 'Gagal mengirim email OTP (mode lokal). Gunakan kode OTP ini: '.$otp);
                } else {
                    return session()->flash('error', 'Gagal mengirimkan kode OTP ke email Anda. Silakan hubungi Administrator.');
                }
            }

            $this->showEmailOTP = true;

            return;
        }

        return session()->flash('error', 'The provided credentials do not match our records.');
    }

    public function verify2FA()
    {
        $this->validate([
            'totp_code' => 'required|string|size:6',
        ], [
            'totp_code.required' => 'Kode TOTP wajib diisi',
            'totp_code.size' => 'Kode TOTP harus terdiri dari 6 digit',
        ]);

        $userId = session('2fa:user_id');
        if (! $userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);
        $google2fa = new \PragmaRX\Google2FA\Google2FA;

        if ($user && $google2fa->verifyKey($user->google2fa_secret, $this->totp_code)) {
            Auth::guard('dashboard')->login($user, session('2fa:remember', false));
            session()->forget(['2fa:user_id', '2fa:remember']);

            return redirect()->intended('/');
        }

        $this->addError('totp_code', 'Kode verifikasi tidak valid.');
    }

    public function verifyEmailOTP()
    {
        $this->validate([
            'email_otp_code' => 'required|string|size:6',
        ], [
            'email_otp_code.required' => 'Kode OTP wajib diisi',
            'email_otp_code.size' => 'Kode OTP harus terdiri dari 6 digit',
        ]);

        $userId = session('2fa:user_id');
        if (! $userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);

        if (! $user || ! $user->email_otp || ! $user->email_otp_expires_at) {
            return redirect()->route('login');
        }

        if (now()->greaterThan($user->email_otp_expires_at)) {
            $this->addError('email_otp_code', 'Kode OTP telah kedaluwarsa. Silakan login kembali.');

            return;
        }

        if ($this->email_otp_code == $user->email_otp) {
            Auth::guard('dashboard')->login($user, session('2fa:remember', false));

            // Clear the OTP fields upon successful login
            $user->email_otp = null;
            $user->email_otp_expires_at = null;
            $user->save();

            session()->forget(['2fa:user_id', '2fa:remember']);

            return redirect()->intended('/');
        }

        $this->addError('email_otp_code', 'Kode verifikasi email tidak valid.');
    }

    public function cancel2FA()
    {
        $userId = session('2fa:user_id');
        if ($userId) {
            $user = \App\Models\User::find($userId);
            if ($user) {
                $user->email_otp = null;
                $user->email_otp_expires_at = null;
                $user->save();
            }
        }

        session()->forget(['2fa:user_id', '2fa:remember']);
        $this->show2FA = false;
        $this->showEmailOTP = false;
        $this->totp_code = '';
        $this->email_otp_code = '';
    }

    protected function guard(): Guard|StatefulGuard
    {
        return Auth::guard('dashboard');
    }

    public function render()
    {
        return view('livewire.main-dashboard.auth.login')
            ->layout('layouts.base');
    }
}
