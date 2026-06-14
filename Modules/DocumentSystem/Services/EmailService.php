<?php

namespace Modules\DocumentSystem\Services;

use PHPMailer\PHPMailer\PHPMailer;

class EmailService
{
    /**
     * Funciton to send email to selected users
     */
    public function sendEmail($data)
    {
        try {
            $config = [
                'name' => env('APP_NAME'),
                'email' => env('MAIL_USERNAME'),
                'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
                'port' => env('MAIL_PORT', 587),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'encryption' => env('MAIL_ENCRYPTION'),
            ];

            $mail = new PHPMailer(true);

            if ($data['type'] == 'new_document') {
                $html = view('email_templates.document_system_review', [
                    'title' => $data['title'],
                    'pic' => $data['pic'],
                    'action_url' => url('document-systems/login'),
                ])->render();

                $subject = trans('global.new_document');
            } else if ($data['type'] == 'almost_expire_document') {
                $html = view('email_templates.almost_expire_document', [
                    'documents' => $data['documents'],
                    'day' => $data['day'],
                ])->render();

                $subject = 'Reminder Expire Document';
            } else if ($data['type'] == 'expire_document') {
                $html = view('email_templates.expire_document', [
                    'documents' => $data['documents'],
                ])->render();

                $subject = 'Expire Document';
            } else if ($data['type'] == 'new_document_jsa') {
                $html = view('email_templates.new_jsa_document', [
                    'title' => $data['title'],
                    'pic' => $data['pic'],
                    'action_url' => route('document-systems'),
                ])->render();

                $subject = trans('global.new_document');
            }

            if (gettype($data['receiver']) == 'string') {
                $data['receiver'] = [$data['receiver']];
            }

            //Server settings
            $mail->isSMTP();
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = env('MAIL_PORT');
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom($config['email'], $config['name']);
            for ($bb = 0; $bb < count($data['receiver']); $bb++) {
                $mail->addAddress($data['receiver'][$bb]);
            }
            $mail->addReplyTo($config['email'], $config['name']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $html;
            //attachments
            if (isset($data['has_attachments'])) {
                if (isset($data['files'])) {
                    $files = $data['files'];
                    for ($aa = 0; $aa < count($files); $aa++) {
                        $mail->addAttachment($files[$aa]);
                    }
                }
            }
            $mail->send();

            return [
                'error' => false,
                'mail' => $mail,
            ];
        } catch (\Throwable $e) {
            return [
                'error' => true,
                'message' => $e->getMessage() . '--' . $e->getLine() . '--' . $e->getFile(),
            ];
        }
    }
}
