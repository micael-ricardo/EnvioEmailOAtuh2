<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TheNetworg\OAuth2\Client\Provider\Azure;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EmailController extends Controller
{
    private $email;
    private $name;
    private $client_id;
    private $client_secret;
    private $token;
    private $provider;

    public function __construct()
    {
        $this->email = 'micael.praxis@outlook.com';
        $this->name = 'Micael Barickshinicovs';
        $this->client_id = env('MICROSOFT_CLIENT_ID');
        $this->client_secret = env('MICROSOFT_CLIENT_SECRET');
        $this->provider = new Azure([
            'clientId' => $this->client_id,
            'clientSecret' => $this->client_secret,
        ]);
    }

    public function doSendEmail(Request $request)
    {
        $this->token = $request->get('oauth_token');

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.office365.com';
            $mail->Port = 25;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth([
                    'provider' => $this->provider,
                    'clientId' => $this->client_id,
                    'clientSecret' => $this->client_secret,
                    'refreshToken' => $this->token,
                    'userName' => $this->email,
                ])
            );

            $mail->setFrom($this->email, $this->name);
            $mail->addAddress('micael.ricardo@outlook.com', 'Micael');
            $mail->Subject = 'Laravel PHPMailer OAuth2 Integration';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<br><br> Teste OAuth2  .<br><br>Email Teste,<br><b>Micael Ricardo</b>';
            $mail->msgHTML($body);
            $mail->AltBody = 'Este é o corpo de uma mensagem de texto simples';
            // dd($mail);
            if ($mail->send()) {
                return redirect()->back()->with('success', 'Email enviado!');
            } else {
                return redirect()->back()->with('error', 'Não é possível enviar e-mail.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }
}
