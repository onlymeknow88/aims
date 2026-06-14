<!DOCTYPE html>
<html>
  <head>
    <title>approval email</title>
  </head>
  <body>
    <table width="100%">
        <tr>
            <td style="padding:40px 30px 30px 30px;text-align:center;font-size:24px;font-weight:bold;">
                <a href="#" style="text-decoration:none;">
                    <img
                        src="https://www.adaro.com/web/assets/common/images/logo-adaro-head.png" width="50%" alt="Logo"
                        style="width:50%;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff;">
                </a>
            </td>
        </tr>

        <tr>
            <td style="text-align:left;font-size:12px;font-weight:bold; margin-top: 10px;">
                Hallo {{ $name }}
            </td>
        </tr>

        <tr>
            <td style="text-align:left;font-size:12px;font-weight:bold; margin-top: 10px;">
                Anda mendapatkan satu pemberitahuan baru untuk melakukan approval pada {{ $module }} halaman berikut
            </td>
        </tr>

        <tr>
            <td style="padding:40px 30px 30px 30px;text-align:center;font-size:24px;font-weight:bold;">
                <a href="{{ $url }}" style="text-decoration:none;">
                    <h3
                        style="margin-top:8px;margin-bottom:0px;font-size:26px;font-weight:bold;color: blue;text-align:center;">
                        Klik Disini</h3>
                </a>
            </td>
        </tr>
    </table>
  </body>
</html>
