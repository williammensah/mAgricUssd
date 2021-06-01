<?php

namespace App\Menus\SubMenus;

use App\ScreenSession;
use Validator;
use App\State\UserState;
use Log;
use App\State\ClientState;

class SelectOtherCrop extends ScreenSession
{
    public $menuName = "select_other_crop";

    public function ask()
    {

       return $this->response($this->getMenuContent(), $this->menuName);
    }

    public function processUserInput($next, $state, $back)
    {

        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|alpha', //user input only letters are required
        ]);

        if ($validator->fails()) {
            Log::info('Validator failed for inputing other crop', [$validator->errors()]);
            return $this->response($this->invalidInput(), $this->menuName);
        }
            (new ClientState)->setState($next, request()->all(), $state['flow']);
            (new UserState)->store(['cropType' => request()->userInput]);
            return $this->nextScreen($state, $next);
    }

}
