<?php

namespace App\Http\Controllers;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Google;

use Google_Client;
use Google_Service_Gmail;

class OAuthSendController extends Controller
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;

    private $refresh_token;

    private $provider;
    private $google_options;

    public function sendEmail()
    {

        
        dd('Entrou');
        // Configurar as credenciais e tokens

        $this->client_id ='480868251972-u9paes2dc5h5v9kd7a5sel39ib1jdj9s.apps.googleusercontent.com';
        $this->client_secret = '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';
        $this->redirect_uri ='https://developers.google.com/oauthplayground';
        $this->refresh_token ='1//04jF9VnV9nrKECgYIARAAGAQSNwF-L9IrO1yyciOqYDvP3At_-RCGfG35wgCG7USW6jHUqWfErdkbPhXstKzsdUmEwJnQLcu5Hmw';
        $params = [
            'clientId' => $this->client_id,
            'clientSecret' => $this->client_secret,
            'redirectUri' => $this->redirect_uri,
        ];
        $this->provider = new Google_Client($params);

        $this->provider->verifyIdToken(['refresh_token' => $this->refresh_token]);


        

        // $accessToken = ['access_token' => $this->refresh_token];
        // $oAuth2Client->getAccessToken($accessToken);

        // $oAuth2Client = new OAuth2\Client($clientId, $clientSecret, $redirectUri);
        // $oAuth2Client->setCredentials(['refresh_token' => $this->refresh_token]);

         $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider' => $this->provider,
                        'clientId' => $this->client_id,
                        'clientSecret' => $this->client_secret,
                        'refreshToken' => $token,
                        'userName' => $this->email,
                    ]
                ));
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
