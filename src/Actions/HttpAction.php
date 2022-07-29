<?php

namespace Vion\TestCase\Actions;

use Illuminate\Support\Facades\Http;

class HttpAction
{
    /**
     * Http post request
     * 
     * @param string $link
     * @param array $body
     * @return $response
     */
    public function post(string $link, array $body)
    {
        $response = Http::withToken((new OauthTokenAction)->handle())->post(env('APP_URL') . $link, $body);

        return $response;
    }

    /**
     * Http get request
     * 
     * @param string $link
     * @return $response
     */
    public function get(string $link)
    {
        $response = Http::withToken((new OauthTokenAction)->handle())->get(env('APP_URL') . $link);

        return $response;
    }

    /**
     * Http put request
     * 
     * @param string $link
     * @param array $body
     * @return $response
     */
    public function put(string $link, array $body)
    {
        $response = Http::withToken((new OauthTokenAction)->handle())->put(env('APP_URL') . $link, $body);

        return $response;
    }
}
