<?php

namespace App\Infrastructure\Clients;

class ExternalServerClient
{
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => env('EXTERNAL_SERVER_URL','https://run.mocky.io')]);
    }

    public function getAuthorizationStatus(): bool
    {
        try {
            $response = $this->client->request('GET', '/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            if ($response->getStatusCode() != 200) {
                throw new \Exception("Error code: ".$response->getStatusCode());
            }
            return json_decode($response->getBody()->getContents())->message == "Autorizado";
        } catch(\Exception $e) {
            throw new \Exception("Error querying for external server. ".$e->getMessage());
        }
    }
}
