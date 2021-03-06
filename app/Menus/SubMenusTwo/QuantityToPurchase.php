<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;

class QuantityToPurchase extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'enter_quantity_purchase';

    public function ask()
    {
        $content = $this->getMenuContent('enter_quantity_purchase');
        return $this->response($content, $this->menuName);
    }

    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for entering quantity purchase', [$validator->errors()]);
            $content = $this->getMenuContent('enter_quantity_purchase');
            $output = $this->prepend($content,$this->invalidInput());
            return $this->response($output, $this->menuName);
        }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['quantityPurchased' => request()->userInput]);
        return $this->nextScreen($state, $next);
    }

}
