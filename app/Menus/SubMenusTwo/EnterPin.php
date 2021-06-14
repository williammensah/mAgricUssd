<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;
use App\ExternalServices\MomoTellerApi;

class EnterPin extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'enter_pin';

    public function ask()
    {
        $userState = (new UserState)->getState();
        $content = $this->getMenuContent('enter_pin');
        $output = str_replace(['{FarmerName}','{10}','{amount}',],[$this->farmerName()['farmerName'],$userState['quantityPurchased'],'420.00'], $content);
        return $this->response($output, $this->menuName);
    }
    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for entering location', [$validator->errors()]);
            return $this->response($this->invalidInput(), $this->menuName);
        }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        return $this->nextScreen($state, $next);
    }

    private function farmerName()
    {
       $farmerDetails = (new MomoTellerApi)->lookupFarmer();
       return $farmerDetails;
    }

}
