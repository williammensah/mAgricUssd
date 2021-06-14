<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;

class CurrentAdvanceLimit extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'current_advance_limit';

    public function ask()
    {
        $output = $this->formatData();
        return $this->response($output, $this->menuName);
    }

    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            Log::info('Validator failed for entering current_advance_limit', [$validator->errors()]);
            $content = $this->formatData();
            $output = $this->prepend($content,$this->invalidInput());
            return $this->response($output, $this->menuName);
        }

        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['currentAdvance' => request()->userInput])->getState();
        return $this->nextScreen($state, $next);
    }


    private function formatData()
    {
        $userState = (new UserState)->getState();
        $content = $this->getMenuContent('current_advance_limit');
        $output = str_replace('{amount}',$userState['limit'],$content);
        return $output;
    }
}
