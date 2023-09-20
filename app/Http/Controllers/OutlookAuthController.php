<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OutlookAuthController extends Controller
{
    public function redirectToProvider()
    {
        $clientId = config('services.microsoft.client_id');
        $redirectUri = route('auth.outlook.callback');
        $scopes = 'https://outlook.office.com/IMAP.AccessAsUser.All openid profile offline_access';

        $authUrl = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize";
        $authUrl .= "?client_id={$clientId}";
        $authUrl .= "&redirect_uri={$redirectUri}";
        $authUrl .= "&scope={$scopes}";
        $authUrl .= "&response_type=code";
        $authUrl .= "&response_mode=query";
        $authUrl .= "&state=" . bin2hex(random_bytes(16));

        return redirect($authUrl);

    }

    public function handleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('outlook')->user();
            $token = $user->token;
            $refreshToken = $user->refreshToken;

            if ($refreshToken != null && !empty($refreshToken)) {
                return redirect()->back()->with('token', $refreshToken);
            } elseif ($token != null && !empty($token)) {
                $request->session()->put('token', $token);
                return redirect()->back();
            } else {
                return redirect()->back()->with('error', 'Unable to retrieve token.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }
}
