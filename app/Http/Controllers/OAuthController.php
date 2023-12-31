<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Google;

class OAuthController extends Controller
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;

    private $provider;
    private $google_options;

    public function __construct()
    {
        $this->client_id = env('GMAIL_API_CLIENT_ID');
        $this->client_secret = env('GMAIL_API_CLIENT_SECRET');
        $this->redirect_uri =   route('token.success');
        $this->google_options = [
            'scope' => [
                'https://mail.google.com/',
            ],  
        ];
        $params = [
            'clientId' => $this->client_id,
            'clientSecret' => $this->client_secret,
            'redirectUri' => $this->redirect_uri,
            'accessType' => 'offline',
        ];
        $this->provider = new Google($params);
    }

    public function GerarToken()
    {
        $redirect_uri = $this->provider->getAuthorizationUrl($this->google_options);
        return redirect($redirect_uri);
    }

    public function SuccessToken(Request $request)
    {

        $code = $request->get('code');

        try {
            $tokenObj = $this->provider->getAccessToken(
                'authorization_code',
                [
                    'code' => $code,
                ]
            );

            $token = $tokenObj->getToken();

            $refresh_token = $tokenObj->getRefreshToken();
            if ($refresh_token != null && !empty($refresh_token)) {
                // return redirect()->action([MailController::class, 'doSendEmail']);
                return redirect()->back()->with('token', $refresh_token);
            } elseif ($token != null && !empty($token)) {
                $request->session()->put('token', $token);
                return redirect()->back();
            } else {
                return redirect()->back()->with('error', 'Unable to retreive token.');
            }
        } catch (IdentityProviderException $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }
}
