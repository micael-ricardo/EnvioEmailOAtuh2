<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;


class EnviarEmailOauthGmail extends Controller
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $refresh_token;

    private $email;
    private $name;

    private $provider;


    public function GerarToken(Request $request)
    {

        $this->client_id = '480868251972-u9paes2dc5h5v9kd7a5sel39ib1jdj9s.apps.googleusercontent.com';
        $this->client_secret = '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';
        $this->redirect_uri = 'https://developers.google.com/oauthplayground';
        $this->refresh_token = '1//04QrTbtAX1pzwCgYIARAAGAQSNwF-L9IrqSDsxkAmnq5vhZi9KFBJ_Rc4VKout71oZpWl9Q7uQzzwM19mxiBAUIposwRU-Yi7vcs';


        $this->email = 'micael.ricardo1997@gmail.com';
        $this->name = 'Micael Barickshinicovs';

        $this->provider = new \League\OAuth2\Client\Provider\Google([
            'clientId' => $this->client_id,
            'clientSecret' => $this->client_secret,
            'redirectUri' => $this->redirect_uri,
        ]);

        $accessToken = $this->provider->getAccessToken('refresh_token', [
            'refresh_token' => $this->refresh_token,
        ]);


        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider' => $this->provider,
                        'token' => $accessToken->getToken(),
                        'clientId' => $this->client_id,
                        'clientSecret' => $this->client_secret,
                        'refreshToken' => $this->refresh_token,
                        'userName' => $this->email,
                    ]
                )
            );
            $mail->setFrom($this->email, $this->name);
            $mail->addAddress('micael.ricardo@outlook.com', 'Micael');
            $mail->Subject = 'Laravel PHPMailer OAuth2 Integration';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<br><br> Teste OAuth2  .<br><br>Email Teste,<br><b>Micael Ricardo</b>';
            $mail->msgHTML($body);
            $mail->AltBody = 'Este é o corpo de uma mensagem de texto simples';

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
