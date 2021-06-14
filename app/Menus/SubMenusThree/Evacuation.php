<?php

namespace App\Menus\SubMenusThree;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;
use App\ExternalServices\MomoTellerApi;

class Evacuation extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'evacuations';

    public function ask()
    {
        $userState = (new UserState)->getState();
        $content = $this->getMenuContent('evacuations');
        return $this->response($content, $this->menuName);
    }
    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for entering purchasing clerk ID', [$validator->errors()]);
            $content = $this->getMenuContent('evacuations');
            $output = $this->prepend($content,$this->invalidInput());
            return $this->response($output, $this->menuName);
        }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['evacuation' => request()->userInput]);
        return $this->nextScreen($state, $next);
    }

   



}
