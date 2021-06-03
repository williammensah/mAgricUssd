<?php

namespace App\Menus\SubMenus;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;
class ValidationMessage extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'validation_screen';


    public function ask($customMessage = null)
    {
        $content = $this->getMenuContent('validation_screen');
        $output = str_replace(['{CustomValidationMessage}'],[$customMessage,''], $content);
        return $this->response($output, $this->menuName);
    }


    public function processUserInput($next, $state, $back)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for selecting otherCrop', [$validator->errors()]);
            return $this->response($this->invalidInput(), $this->menuName);
        }

        if (request()->userInput == '1') {
            return $this->nextScreen($state, $back);
        }
        //   (new ClientState)->setState($next, request()->all(), $state['flow']);
        //   (new UserState)->store(['cropType' => request()->userInput]);
        //     return $this->nextScreen($state, $next);

    }
}
