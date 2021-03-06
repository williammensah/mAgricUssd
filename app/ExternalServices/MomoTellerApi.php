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

    public function purchasingClerk()
    {
        return  [
            'responseCode' => 200,
            'responseMessage' => 'success',
            'data' => [
                'name' => 'John Doe',
                'total' => '5bags',
                'balance' => '3bags 12kgs',
                'role' => 'purchasing_clerk',
                'limit' => '500',
                'buffer' => '520'
            ]
        ];
    }

    public function evacuationUser()
    {
        return [
            'responseCode' => 200,
            'responseMessage' => 'success',
            'data' => [
                'name' => 'William Doe',
                'role' => 'depot keeper'
            ]
        ];
    }

    public function lookUpPurchasingClerk($msisdn)
    {
        return Cache::remember($msisdn, $ttl = 60, function () {
            $response =  $this->purchasingClerk();
            if ($response && $response['responseCode'] == 200) {
                return $response['data'];
            }
            Log::info('Did not get a success response  from lookup purchasing clerk');
            return null;
        });
    }

    public function purchasingClerkHistory()
    {
        return [
            'responseCode' => 200,
            'responseMessage' => 'transaction history successfully fetched',
            'data' => [
                [
                    'clerk_id' => 10359,
                    'transaction_id' => "20210323605A0021A2C44",
                    'clerk_phone_number' => "233556304507",
                    'bags' => "50",
                    'created_at' => "2021-03-23 15:00:30"
                ],
                [
                    'clerk_id' => 10359,
                    'transaction_id' => "20210323605A0021A2C44",
                    'clerk_phone_number' => "233556304507",
                    'bags' => "50",
                    'created_at' => "2021-04-23 15:00:30"
                ],
                [
                    'clerk_id' => 10359,
                    'transaction_id' => "20210323605A0021A2C44",
                    'clerk_phone_number' => "233556304507",
                    'bags' => "50",
                    'created_at' => "2021-04-13 15:00:30"
                ],
                [
                    'clerk_id' => 10359,
                    'transaction_id' => "20210323605A0021A2C44",
                    'clerk_phone_number' => "233556304507",
                    'bags' => "50",
                    'created_at' => "2021-05-23 15:00:30"
                ],
                [
                    'clerk_id' => 10359,
                    'transaction_id' => "20210323605A0021A2C44",
                    'clerk_phone_number' => "233556304507",
                    'bags' => "50",
                    'created_at' => "2021-03-23 15:00:30"
                ],
                [
                    'clerk_id' => 10359,
                    'transaction_id' => "20210323605A0021A2C44",
                    'clerk_phone_number' => "233556304507",
                    'bags' => "50",
                    'created_at' => "2021-03-23 15:00:30"
                ]
            ]
        ];
    }

    public function getPurchasingClerkHistory()
    {
        $response = $this->purchasingClerkHistory();
        if ($response && $response['responseCode'] == 200) {
            return $response;
        }
    }
    public function lookupFarmer()
    {
        $response = [];
        $response['responseCode'] = 200;
        $response['responseMessage'] = 'Operation Successful';
        $response['farmerName'] =  'Sammuel Enniful';
        if ($response['responseCode'] == 200) {
            return $response;
        }
        return false;
    }

    public function produce()
    {
        $data = [
            'Cocoa',
            'Coffee',
            'Cashew'
        ];
        return $this->resetArrayIndexToStartFromOne($data);
    }

    public function pendingEvacuation()
    {
        $data = [
            'Cocoa 24 bags',
            'Coffee 50 bags',
            'Cashew 64 bags'
        ];
        return $this->resetArrayIndexToStartFromOne($data);
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
    public function formatData($networks)
    {
        $netRes = '';
        foreach ($networks as $key => $network) {
            $netRes .= "$key. $network ".PHP_EOL;
        }
        return $netRes;
    }
}
