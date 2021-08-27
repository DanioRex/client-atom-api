<?php

namespace DanioRex\AtomApiBuild;

use SoapClient;
use SoapFault;

class SoapConnection
{
    protected int $max_attempts = 3;
    protected SoapClient $client;
    protected array $auth;

    public function __construct(string $api_url, string $login, string $password)
    {
        try {
            $this->client = new SoapClient($api_url, [
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    ]
                ])
            ]);
            $this->auth = [
                'login' => $login,
                'password' => $password
            ];
            $this->testConnection();
        } catch (SoapFault $e) {
            error_log($e->getMessage());
            die();
        }
    }

    private function testConnection(): void
    {
        $response = $this->client->CheckConnection($this->auth);
        if ($response != 'OK') {
            error_log($response);
            die();
        }
    }

    protected function try(string $method): string
    {
        $attempts = 0;
        do {
            try {
                $response = $method;
            } catch (SoapFault $e) {
                $attempts++;
                sleep(1);
                if ($attempts == $this->max_attempts) {
                    error_log($e);
                    die();
                }
                continue;
            }
            break;
        } while ($attempts < $this->max_attempts);
        return $response;
    }
}