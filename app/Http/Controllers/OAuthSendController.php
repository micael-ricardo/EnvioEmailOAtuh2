<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Google;

class OAuthSendController extends Controller
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;

    private $provider;
    private $google_options;

    public function __construct(Request $request)
    {
        $this->client_id = $request->input('clienteId');
        $this->client_secret = $request->input('clienteSecret');
        $this->redirect_uri = route('token.success');
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

    public function GerarToken(Request $request)
    {
        $request->session()->put('clienteId', $this->client_id);
        $request->session()->put('clienteSecret', $this->client_secret);

        $redirect_uri = $this->provider->getAuthorizationUrl($this->google_options);
        return redirect($redirect_uri);

    }

    public function SuccessToken(Request $request)
    {
        $clientId = $request->session()->get('clienteId');
        $clientSecret = $request->session()->get('clienteSecret');
        
        $params = [
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $this->redirect_uri,
            'accessType' => 'offline',
        ];
        $this->provider = new Google($params);

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
                return redirect()->back()->with('token', $refresh_token);
            } elseif ($token != null && !empty($token)) {
                $request->session()->put('token', $token);
                return redirect()->back();
            } else {
                return redirect()->back()->with('error', 'Unable to retrieve token.');
            }
        } catch (IdentityProviderException $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }
}
