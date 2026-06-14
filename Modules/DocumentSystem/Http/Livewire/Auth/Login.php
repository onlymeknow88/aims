<?php

namespace Modules\DocumentSystem\Http\Livewire\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\DocumentSystem\View\Layouts\Base;

class Login extends Component
{
    use AuthenticatesUsers, LivewireAlert;

    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected function getRules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            'remember' => 'nullable'
        ];
    }

    public function login()
    {
        $this->validate();

        $auth = Auth::guard('document-system')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember);

        if ($auth) {
            $this->flash('success', 'Berhasil Login!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect('/document-systems');
        } else {
            $this->alert('error', 'Gagal, Email atau password tidak sesuai.', [
                'position' => 'center-end'
            ]);
        }
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        $this->redirectRoute('document-system::dashboard');
    }

    protected function guard(): Guard|StatefulGuard
    {
        return Auth::guard('document-system');
    }

    public function render()
    {
        return view('documentsystem::livewire.auth.login')
            ->layout(Base::class);
    }
}
