<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use TheNetworg\OAuth2\Client\Provider\Azure;

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
        try {
            $this->token = $request->get('oauth_token');

            $graph = new Graph();
            $graph->setAccessToken($this->token);

            $message = new Model\Message();
            $message->setSubject('Laravel Microsoft Graph Integration');
            $message->setBody([
                'contentType' => 'HTML',
                'content' => '<br><br>Teste OAuth2.<br><br>Email Teste,<br><b>Micael Ricardo</b>',
            ]);
            $message->setToRecipients([
                [
                    'emailAddress' => [
                        'address' => 'micael.ricardo1997@gmail.com',
                    ],
                ],
            ]);

            $graph->createRequest('POST', '/me/sendMail')
                ->attachBody($message)
                ->execute();

            return redirect()->back()->with('success', 'Email enviado!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

}
