<?php

namespace App\Infrastructure\Clients;

use App\Domain\Marketplace\Transaction;

class NotificationClient
{
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => env('NOTIFICATION_SERVER_URL','http://o4d9z.mocklab.io')]);
    }

    public function pub(Transaction $transaction): void
    {
        try {
            $response = $this->client->request(
                'GET',
                '/notify',
                [
                    'body' => json_encode([$transaction->toArray(), $transaction->getPayer()->toArray(), $transaction->getPayee()->toArray()])
                ]
            );
            if ($response->getStatusCode() != 200) {
                throw new \Exception("Error code: ".$response->getStatusCode());
            }
        } catch(\Exception $e) {
            throw new \Exception("Error pub notification server. ".$e->getMessage());
        }
    }
}
