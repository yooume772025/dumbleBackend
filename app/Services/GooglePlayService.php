<?php

namespace App\Services;

use Google_Client;
use Google_Service_AndroidPublisher;

class GooglePlayService
{
    protected $client;

    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('secure/dumble-467104-b9c1c92d89fb.json'));
        $this->client->addScope(Google_Service_AndroidPublisher::ANDROIDPUBLISHER);

        $this->service = new Google_Service_AndroidPublisher($this->client);
    }

    public function verifySubscription($packageName, $subscriptionId, $purchaseToken)
    {
        try {
            $subscription = $this->service->purchases_subscriptions->get(
                $packageName,
                $subscriptionId,
                $purchaseToken
            );

            return $subscription;
        } catch (\Exception $e) {
            return false;
        }
    }
}
