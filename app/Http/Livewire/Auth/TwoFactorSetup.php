<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TwoFactorSetup extends Component
{
    public $secretKey = '';
    public $qrCodeImage = '';
    public $totpCode = '';
    public $message = '';
    public $messageType = '';

    public function mount()
    {
        $user = Auth::guard('dashboard')->user();
        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->google2fa_secret) {
            $this->generateSecret();
        }
    }

    public function generateSecret()
    {
        $user = Auth::guard('dashboard')->user();
        $google2fa = new Google2FA();
        $this->secretKey = $google2fa->generateSecretKey();
        
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'AIMS',
            $user->email,
            $this->secretKey
        );

        $this->qrCodeImage = 'data:image/svg+xml;base64,' . base64_encode(
            QrCode::format('svg')->size(200)->errorCorrection('H')->generate($qrCodeUrl)
        );
    }

    public function enable2FA()
    {
        $this->validate([
            'totpCode' => 'required|string|size:6'
        ], [
            'totpCode.required' => 'Kode verifikasi wajib diisi',
            'totpCode.size' => 'Kode verifikasi harus 6 digit'
        ]);

        $user = Auth::guard('dashboard')->user();
        $google2fa = new Google2FA();

        if ($google2fa->verifyKey($this->secretKey, $this->totpCode)) {
            $user->google2fa_secret = $this->secretKey;
            $user->google2fa_enabled = true;
            $user->save();

            $this->message = 'Otentikasi Dua Faktor (2FA) berhasil diaktifkan!';
            $this->messageType = 'success';
            $this->totpCode = '';
        } else {
            $this->addError('totpCode', 'Kode verifikasi salah. Silakan coba lagi.');
        }
    }

    public function disable2FA()
    {
        $user = Auth::guard('dashboard')->user();
        $user->google2fa_secret = null;
        $user->google2fa_enabled = false;
        $user->save();

        $this->message = 'Otentikasi Dua Faktor (2FA) berhasil dinonaktifkan.';
        $this->messageType = 'info';
        $this->secretKey = '';
        $this->qrCodeImage = '';
        $this->totpCode = '';

        $this->generateSecret();
    }

    public function render()
    {
        return view('livewire.auth.two-factor-setup')
            ->extends('layouts.main-dashboard.dashboard-white');
    }
}
