<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;

class ConfirmNewPin extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'confirm_new_pin';

    public function ask()
    {
        $content = $this->getMenuContent('confirm_new_pin');
        return $this->response($content, $this->menuName);
    }
    
    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|digits:4'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for confirming pin', [$validator->errors()]);
            $content =$this->getMenuContent('confirm_new_pin');
            $output = $this->prepend($content, $this->invalidInput());
            return $this->response($output, $this->menuName);
        }
          $userState = (new UserState)->getState();
         if (request()->userInput !== $userState['newPin']) {
             $message = 'invalid Input'.PHP_EOL.'Pin mismatch!'.PHP_EOL;
            $content = $this->getMenuContent('confirm_new_pin');
            $output = $this->prepend($content,$this->invalidInput($message));
            return $this->response($output, $this->menuName);
         }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        return $this->nextScreen($state, $next);
    }
}
