<?php

namespace App\Menus\SubMenus;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;
use App\Menus\SubMenus\SelectOtherCrop;
class SelectTypeOfCrop extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'select_type_of_crop';
    public function processUserInput($next, $state, $back)
    {

        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|in:1,2,3,4'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for selecting type of crop', [$validator->errors()]);
            $content = $this->getMenuContent('select_type_of_crop');
            return $this->response($content, $this->menuName);
        }

        if (request()->userInput == $this->OTHERCROP) {
            (new ClientState)->setState($next, request()->all(), $state['flow']);
            return (new SelectOtherCrop)->ask($state);
        }
          (new ClientState)->setState($next, request()->all(), $state['flow']);
          (new UserState)->store(['cropType' => request()->userInput]);
            return $this->nextScreen($state, $next);

    }
}
