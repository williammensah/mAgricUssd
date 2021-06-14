<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;
use App\ExternalServices\MomoTellerApi;

class FarmerData extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'farmer_data';

    public function ask()
    {
       $output = $this->formatData();
        return $this->response($output, $this->menuName);
    }

    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for confirming farmer Data', [$validator->errors()]);
             $output = $this->formatData();
            return $this->response($output, $this->menuName);
        }
        (new UserState)->store(['confirmed' => request()->userInput]);
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        return $this->nextScreen($state, $next);
    }


    private function formatData()
    {
        $data = $this->callApi();
        $content = $this->getMenuContent('farmer_data');
        $output = str_replace(['{farmerName}'], [$data], $content);
        return $output;
    }
    private function callApi()
    {
       $farmerDetails = (new MomoTellerApi)->lookupFarmer();
       return $farmerDetails['farmerName'];
    }
}
