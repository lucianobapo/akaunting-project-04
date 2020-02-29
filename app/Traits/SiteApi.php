<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait SiteApi
{

    protected static function getRemote($url, $data = array())
    {
        if (config('app.env')=='local') return;
        
        $base = 'https://akaunting.com/api/';

        $client = new Client(['verify' => false, 'base_uri' => $base]);

        $headers['headers'] = array(
            'Authorization' => 'Bearer ' . setting('general.api_token'),
            'Accept'        => 'application/json',
            'Referer'       => url('/'),
            'Akaunting'     => version('short'),
            'Language'      => language()->getShortCode()
        );

        $data['http_errors'] = false;

        $data = array_merge($data, $headers);

        try {
            dbg('SiteApi.php: GuzzleHttp\Client ->get() called - '.$url);
            $result = $client->get($url, $data);
        } catch (RequestException $e) {
            $result = $e;
        }

        return $result;
    }
}
