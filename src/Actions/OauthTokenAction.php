<?php

namespace Vion\TestCase\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OauthTokenAction
{
    /**
     * Set api auth for test
     * @return string
     */
    public function handle(): ?string
    {
        $oauthClientId = env('VION_OAUTH_CLIENT_ID') ? env('VION_OAUTH_CLIENT_ID') : 3;
        $oauthClient = DB::table('oauth_clients')->findOrFail($oauthClientId);

        if ($oauthClient) {
            $body = [
                'username' => env('VION_USERNAME_TEST') ? env('VION_USERNAME_TEST') : 'admin@admin.ru',
                'password' => env('VION_PASSWORD_TEST') ? env('VION_PASSWORD_TEST') : 'password',
                'client_id' => $oauthClientId,
                'client_secret' => $oauthClient->secret,
                'grant_type' => 'password',
                'scope' => '*'
            ];

            $response = Http::post(env('APP_URL') . '/oauth/token', $body);
            $data = json_decode($response->body());
            
            return $data->access_token;
        }

        return null;
    }
}
