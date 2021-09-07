<?php

namespace DanioRex\AtomApiBuild;

use SoapClient;
use SoapFault;

/**
 * Atomstore Soap API Connection with Authorization check and calling methods retrying on fail
 */
class SoapConnection
{
    /**
     * @var int
     */
    protected int $max_attempts = 3;
    /**
     * @var SoapClient
     */
    protected SoapClient $client;
    /**
     * @var array|string[]
     */
    protected array $auth;

    /**
     * @param string $api_url
     * @param string $login
     * @param string $password
     */
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

    /**
     *
     */
    private function testConnection(): void
    {
        $response = $this->client->CheckConnection($this->auth);
        if ($response != 'OK') {
            error_log($response);
            die();
        }
    }

    /**
     * @param string $method
     * @param array $params
     * @return string|null
     */
    protected function try(string $method, array $params = []): string
    {
        $attempts = 0;
        do {
            try {
                array_unshift($params, $this->auth);
                $response = $this->client->__soapCall($method, $params);
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
        return $response ?? 'SOMETHING WENT HORRIBLY WRONG';
    }
}