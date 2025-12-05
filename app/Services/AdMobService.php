<?php

namespace App\Services;

use Google_Client;
use Google_Service_AdMob;

class AdMobService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('secure/dumble-467104-c351658e76cd.json'));
        $this->client->addScope('https://www.googleapis.com/auth/admob.readonly');
    }

    public function getAdMobReport()
    {
        try {
            $service = new Google_Service_AdMob($this->client);

            $account = 'accounts/pub-7842872470443985';

            $request = new \Google_Service_AdMob_GenerateNetworkReportRequest(
                [
                'reportSpec' => [
                    'dateRange' => [
                        'startDate' => ['year' => 2025, 'month' => 7, 'day' => 1],
                        'endDate' => ['year' => 2025, 'month' => 7, 'day' => 30],
                    ],
                    'metrics' => ['ESTIMATED_EARNINGS', 'IMPRESSIONS'],
                    'dimensions' => ['DATE'],
                ],
                ]
            );

            $response = $service->accounts_networkReport->generate($account, $request);

            $result = [];
            foreach ($response->getRows() as $row) {
                $date = $row->getDimensionValues()['DATE']->getValue();
                $earnings = $row->getMetricValues()['ESTIMATED_EARNINGS']
                ->getMicrosValue() / 1000000;
                $impressions = $row->getMetricValues()['IMPRESSIONS']->getIntegerValue();
                $result[] = [
                'date' => $date,
                'earnings' => $earnings,
                'impressions' => $impressions,
                ];
            }

            return $result;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
