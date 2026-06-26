<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP AIMS</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 0; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 550px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <!-- Header -->
        <tr>
            <td style="background-color: #063D56; padding: 30px; text-align: center;">
                <h2 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 1px;">AIMS SECURITY</h2>
                <p style="color: #93c5fd; margin: 5px 0 0 0; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Alamtri Integrated Management System</p>
            </td>
        </tr>
        
        <!-- Content -->
        <tr>
            <td style="padding: 40px 35px; color: #334155; line-height: 1.6;">
                <p style="margin: 0 0 20px 0; font-size: 16px;">Halo,</p>
                <p style="margin: 0 0 25px 0; font-size: 15px;">Seseorang mencoba masuk ke akun AIMS Anda. Gunakan kode verifikasi di bawah ini untuk melanjutkan masuk. Kode ini hanya berlaku selama <strong>10 menit</strong>.</p>
                
                <!-- OTP Box -->
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 30px auto; background-color: #f1f5f9; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <tr>
                        <td style="padding: 15px 40px; font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #0f172a; text-align: center;">
                            {{ $otp }}
                        </td>
                    </tr>
                </table>
                
                <p style="margin: 0 0 10px 0; font-size: 14px; color: #64748b;">Jika Anda tidak mencoba masuk ke akun Anda, abaikan email ini atau hubungi tim Administrator IT AIMS.</p>
            </td>
        </tr>
        
        <!-- Footer -->
        <tr>
            <td style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #f1f5f9; font-size: 12px; color: #94a3b8;">
                &copy; {{ date('Y') }} PT Alamtri Resources. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
