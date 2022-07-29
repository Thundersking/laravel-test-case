<?php

namespace Vion\TestCase\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait HttpTrait
{
    /**
     * Token
     * @var string
     */
    private static ?string $_token = null;

    /**
     * {@inheritdoc}
     * @see \Tests\TestCase
     */
    public function withToken(string $token = null, string $type = 'Bearer')
    {
        $token = $token ?: $this->getToken();

        return parent::withToken($token, $type);
    }

    /**
     * {@inheritdoc}
     * @see \Tests\TestCase
     */
    public function get($uri, array $headers = [])
    {
        $uri .= strpos($uri, '?') ? '&' : '?';
        $uri .= 'isTest=1';

        return parent::get($uri, $headers);
    }

    /**
     * {@inheritdoc}
     * @see \Tests\TestCase
     */
    public function post($uri, array $data = [], array $headers = [])
    {
        $data['isTest'] = true;

        return parent::post($uri, $data, $headers);
    }

    /**
     * {@inheritdoc}
     * @see \Tests\TestCase
     */
    public function put($uri, array $data = [], array $headers = [])
    {
        $data['isTest'] = true;

        return parent::put($uri, $data, $headers);
    }

    /**
     * {@inheritdoc}
     * @see \Tests\TestCase
     */
    public function delete($uri, array $data = [], array $headers = [])
    {
        $data['isTest'] = true;

        return parent::delete($uri, $data, $headers);
    }

    /**
     * Get oath token
     * @return string
     */
    private function getToken(): ?string
    {
        if (!self::$_token) {
            $oauthClientId = 3;
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

                self::$_token = $data->access_token;
            }
        }

        return self::$_token;
    }
}
