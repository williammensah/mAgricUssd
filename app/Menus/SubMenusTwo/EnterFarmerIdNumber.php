<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;

class EnterFarmerIdNumber extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'enter_farmer_id_number';


    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for entering farmerId', [$validator->errors()]);
            $content = $this->getMenuContent('enter_farmer_id_number');
            $output = $this->prepend($content,$this->invalidInput());
            return $this->response($output, $this->menuName);
        }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['farmerIdNumber' => request()->userInput]);
        return $this->nextScreen($state, $next);
    }


}
