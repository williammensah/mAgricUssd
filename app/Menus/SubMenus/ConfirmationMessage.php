<?php

namespace App\Menus\SubMenus;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;

class ConfirmationMessage extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'confirmation_messsage';

    public function ask()
    {
        $content = $this->getMenuContent('confirmation_messsage');
        // return $this->response($content, $this->menuName);
        return $this->endSession($content, 'confirmation_messsage');
    }

}
