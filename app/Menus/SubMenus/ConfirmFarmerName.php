<?php

namespace App\Menus\SubMenus;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use Validator;
use App\Menus\SubMenus\ValidationMessage;
use App\ExternalServices\MomoTellerApi;

class ConfirmFarmerName extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'confirm_farmer_name';

    public function ask()
    {
        Log::info('confirm farmer name Ask');
        $userState = (new UserState)->getState();
        $output  = $this->callApi();
        return $this->response($output, $this->menuName);
    }

    public function processUserInput($next, $state, $back)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|in:1,2'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for selecting Farmer Name', [$validator->errors()]);
            $output = $this->callApi();
            return $this->response($output, $this->menuName);
        }

        if (request()->userInput == $this->CONFIRM) {
            (new UserState)->store(['confirmed' => request()->userInput])->getState();
            (new ClientState)->setState($next, request()->all(), $state['flow']);
            return $this->nextScreen($state, $next);
        }

        if (request()->userInput == $this->CANCEL) {
            Log::info('Farmer session ended - cancelled');
            return $this->endSession("Exiting", $this->menuName);
        }
    }

    private function callApi()
    {
        try {
            $famerName = (new MomoTellerApi)->lookupFarmer();
            $content = $this->getMenuContent('confirm_farmer_name');
            $output = str_replace(['{name}'], [$famerName['farmerName'],''], $content);
            return $output;
        } catch (\Throwable $th) {
            \Log::error("An error occurred retrieving  farmerName from api ",[$th]);
        }
    }
}
