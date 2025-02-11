<?php

namespace App\Services\BolusReading;

use AllowDynamicProperties;
use App\Models\BolusReading;
use \App\Services\Service;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BolusReadingApiService extends Service
{
    protected BolusReading $bolus;
    protected string $cookie = '';
    protected string $url;
    protected string $login;
    protected string $password;
    public function __construct()
    {
        parent::__construct();
        $this->url = config('api.url');
        $this->login = config('api.login');
        $this->password = config('api.password');
    }

    /**
     * @throws ConnectionException
     */
    public function auth(): void
    {
        \Laravel\Prompts\info('start auth');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->post($this->url . '/auth/login', [
                'login' => $this->login,
                'password' => $this->password,
                'credentials' => base64_encode($this->login . ':' . $this->password),
            ]);

        cache()->set('token', $response->json()['result']);
    }

    /**
     * @throws ConnectionException
     */
    public function getReadings($deviceNumber)
    {
        $query =[
            'deviceId' => $deviceNumber,
            'startDate' => $this->getStartDate($deviceNumber),
            'endDate' => $this->getEndDate(),
        ];
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Cookie' => cache('token'),
        ])->get($this->url . '/record/all', $query);

        if ($response->json()['state'] == 'FAULT') {
            \Laravel\Prompts\info('FAULT');

            $this->auth();
            $this->getReadings($deviceNumber);
        }
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function pullRecords($deviceNumber): void
    {
        $readingsArray = $this->getReadings($deviceNumber);
        if ($readingsArray['state'] != 'OK') {
            \Laravel\Prompts\info('failed');
        }
        $results = $readingsArray['result'];
        foreach ($results as $key => $result) {
            $code = strtolower($result['code']);
            foreach ($result['records'] as $record) {
                try {
                    $date = Carbon::make($record['date'])?->format('Y-m-d\TH:i:s.uP');

                    $reading = BolusReading::updateOrCreate([
                        'device_number' => $deviceNumber,
                        'date' => $date,
                    ], [
                        $code => floatval($record['value']),
                    ]);
                } catch (\Exception $exception) {
                    Log::error( __METHOD__." ". $exception->getMessage());
                }
            }
        }


    }

    private function getStartDate($deviceNumber): string
    {
        $latestData = BolusReading::query()->where('device_number',$deviceNumber)->latest('date')->first()?->date;
        if ($latestData) {
            return Carbon::make($latestData)->format('d.m.Y');
        }
        return Carbon::make('2024-01-01')->format('d.m.Y');
    }
    private function getEndDate()
    {
        return Carbon::make(Carbon::now())->format('d.m.Y');
    }
}
