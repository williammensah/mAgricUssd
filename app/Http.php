<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Log;

class Http
{
    protected $client;
    public static function get($url, $headers = [])
    {
        Log::info('Http Request to ' . $url, ['Headers' => $headers]);
        $client = new Client;

        try {
            $request = $client->get($url, [
                'headers' => array_merge($headers, [
                    'Content-Type' => 'application/json',
                ]),
            ]);
            $response = $request->getBody();
            $response = json_decode($response, true);
            Log::info('Response From Http Request', [$response]);
            return $response;
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody() ?? false, true);
        } catch (\Throwable $e) {
            return false;
        }
    }
    public static function post($url, $data, $headers = [])
    {
        $client = new Client;
        Log::info('Making post request', ['url' => $url, 'data' => $data, 'Headers' => $headers]);
        try {
            $request = $client->post($url, [
                'headers' => array_merge($headers, ['Content-Type' => 'application/json']),
                'json' => $data,
            ]);
            $response = $request->getBody();
            $response = json_decode($response, true);

            Log::info('Response From Http Post Request', ['Response' => $response]);
            return $response;
        } catch (RequestException $e) {
            Log::info('Client Exception', ['Error' => $e->getMessage(), 'Stack Trace' => $e]);
            return json_decode($e->getResponse()->getBody(), true);
        } catch (\Throwable $e) {
            Log::info('An error occured', ['Error' => $e->getMessage(), 'data' => $data, 'Stack Trace' => $e]);
            return false;
        }
    }

    ## Posting params as a string and receiving response as a string(text)
    public function httpPostText($url, $data, $headers = null)
    {
        $this->setUp();
        $this->client = new Client;
        $request = $this->client->post($url, [
            'headers' => $headers ?? ['Content-Type' => 'text/plain'],
            'body' => $data,
        ]);
        $response = $request->getBody();
        // $response = json_decode($response);
        return (string) $response;
    }
    public function httpUpdate()
    {
    }
    public function httpDelete()
    {
    }
}
