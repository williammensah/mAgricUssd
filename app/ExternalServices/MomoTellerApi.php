<?php

namespace App\ExternalServices;

use App\Http;
use Cache;
use Log;

class MomoTellerApi
{
    protected $url;
    public function __construct()
    {
        $this->url = config('services.momo_teller_api.url');
    }


    public function lookupFarmer()
    {
        $response = [];
        $response['responseCode'] = 200;
        $response['responseMessage'] = 'Operation Successfull';
        $response['farmerName'] =  'Sammuel Enniful';
        if ($response['responseCode'] == 200) {
            return $response;
        }
        return false;
    }

    public function getAvailableNetworks()
    {
        $response = Http::get($this->url . '/available/networks');
        if ($response && $response['responseCode'] == 200) {
            return $this->resetArrayIndexToStartFromOne($response['data']);
        }
        return false;
    }
    public function lookupAgent($msisdn)
    {
        return Cache::remember($msisdn, $ttl = 60, function () use ($msisdn) {
            // $response = Http::get($this->url . '/lookup?' . http_build_query(['msisdn' => $msisdn]));
            // if ($response && $response['responseCode'] == 200) {
            //     return $response['data'];
            // }
           return  $this->lookupFarmer();
            Log::info('Did not get a success from Agent Lookup');
            return null;
        });

    }
    public function cashDeposit($data)
    {
        $data = array_merge($data, ['source' => 'ussd']);
        $response = Http::post($this->url . '/cash-deposit', $data);
        return $response;
    }
    public function transactionHistory($msisdn, $tellerId, $pageNumber = 1, $perPage = 2)
    {
        $response = Http::get($this->url . '/transaction-history?' . http_build_query(['msisdn' => $msisdn, 'tellerId' => $tellerId, 'per_page' => $perPage, 'page' => $pageNumber]));
        if ($response && $response['responseCode'] == 200) {
            return $response['data'];
        }
        return false;
    }

    public function sendEcash($data)
    {
        $data = array_merge($data, ['source' => 'ussd']);
        $response = Http::post($this->url . '/send-ecash', $data);
        return $response;
    }

    public function getEcash($data)
    {
        $data = array_merge($data, ['source' => 'ussd']);
        $response = Http::post($this->url . '/receive-ecash', $data);
        return $response;
    }
    public function cashWithdrawal()
    {
    }
    public function lookupCustomer()
    {
        return ['lookupName' => 'Jane Doe'];
    }

    public function resetArrayIndexToStartFromOne($networks)
    {
        return array_filter(array_merge(array(0), $networks));
    }
    public function formatNetworks($networks)
    {
        $netRes = '';
        foreach ($networks as $key => $network) {
            $netRes .= "$key. $network<br>";
        }
        return $netRes;
    }
}
