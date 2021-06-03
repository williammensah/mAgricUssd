<?php

namespace App\Menus\SubMenus;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;

class SelectQuantityOfLastSafe extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'select_quantity_of_last_safe';
    public function processUserInput($next, $state, $back)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|in:1,2,3,4,5',
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for selecting  quantity of safe', [$validator->errors()]);
            $content = $this->getMenuContent('select_quantity_of_last_safe');
            //$this->invalidInput();
            return $this->response($content, $this->menuName);
        }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['lastSafe' => request()->userInput]);
        return $this->nextScreen($state, $next);
    }
}
