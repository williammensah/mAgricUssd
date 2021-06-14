<?php

namespace App\Menus\SubMenus;

use App\ScreenSession;
use Validator;
use App\State\UserState;
use Log;
use App\State\ClientState;

class Location extends ScreenSession
{
    public $menuName = "enter_location";

    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|alpha'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for entering location', [$validator->errors()]);
            $content =$this->getMenuContent('enter_location');
            $output = $this->prepend($content, $this->invalidInput());
            return $this->response($output, $this->menuName);
        }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['location' => request()->userInput]);
        return $this->nextScreen($state, $next);
    }
}
