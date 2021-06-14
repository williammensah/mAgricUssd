<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;

class ConfirmFarmerIdNumber extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'confirm_farmer_id_number';


    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for entering farmerId', [$validator->errors()]);
            $content = $this->getMenuContent('confirm_farmer_id_number');
            $output = $this->prepend($content,$this->invalidInput());
            return $this->response($output, $this->menuName);
        }
        $userState =  (new UserState)->getState()['farmerIdNumber'];
         if ($userState !== request()->userInput) {
            $output = $this->checkFarmerId();
            return $this->response($output,$this->menuName);
         }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['FarmerIdNumber' => request()->userInput])->getState();
        return $this->nextScreen($state, $next);
    }

    private function checkFarmerId()
    {
            $validationMessage = 'Farmer ID do not match!'.PHP_EOL.'Kindly try again';
            $content = $this->getMenuContent('confirm_farmer_id_number');
            $output = $this->prepend($content,$this->invalidInput($validationMessage));
            return $output;
    }

}
