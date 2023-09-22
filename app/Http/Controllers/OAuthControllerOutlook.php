<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TheNetworg\OAuth2\Client\Provider\Azure;

class OAuthControllerOutlook extends Controller
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $tenant_id;

    public function __construct()
    {
        $this->client_id = env('MICROSOFT_CLIENT_ID');
        $this->client_secret = env('MICROSOFT_CLIENT_SECRET');
        $this->redirect_uri = route('token.success');
        $this->tenant_id = env('MICROSOFT_CLIENT_TENANT');
    }

    public function GerarToken()
    {
        $provider = new Azure([
            'clientId' => $this->client_id,
            'clientSecret' => $this->client_secret,
            'redirectUri' => $this->redirect_uri,
            'tenant' => $this->tenant_id,
            'scopes' => ['openid'],
            'defaultEndPointVersion' => '2.0',
        ]);

        $authorizationUrl = $provider->getAuthorizationUrl();
        session(['oauth_state' => $provider->getState()]);

        return redirect()->away($authorizationUrl);
    }

    public function SuccessToken(Request $request)
    {
        $provider = new Azure([
            'clientId' => $this->client_id,
            'clientSecret' => $this->client_secret,
            'redirectUri' => $this->redirect_uri,
            'tenant' => $this->tenant_id,
            'scopes' => ['openid'],
            'defaultEndPointVersion' => '2.0',
        ]);

        $state = $request->session()->pull('oauth_state');

        $code = $request->get('code');

        try {
            $tokenObj = $provider->getAccessToken('authorization_code', [
                'code' => $code,
            ]);
            $token = $tokenObj->getToken();
            $refresh_token = $tokenObj->getRefreshToken();
            if ($refresh_token != null && !empty($refresh_token)) {
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
