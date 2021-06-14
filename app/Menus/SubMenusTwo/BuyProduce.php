<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;
use App\ExternalServices\MomoTellerApi;
use App\Menus\MainMenuTwo;

class BuyProduce extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'buy_produce';

    public function ask()
    {
        $content = $this->getMenuContent('buy_produce');
        return $this->response($content, $this->menuName);
    }

    public function nextScreen($state, $next, $data = null)
    {
        if ($next === 'main_menu2' || $next === 'ROOT') {
            return $this->goToMainMenu();
        }
        return $this->mapToMenu($state, $next, $data);
    }

    public function processUserInput($next, $state)
    {

        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|in:1,2,3'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for selecting a produce', [$validator->errors()]);
            return $this->response($this->getMenuContent('buy_produce'), $this->menuName);
        }
        $selectedProduce = $this->checkProduceValue(request()->userInput);
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['produce' => $selectedProduce]);
        return $this->nextScreen($state, $next);
    }


    public function goToMainMenu()
    {
        return (new MainMenuTwo)->index();
    }

    private function checkProduceValue($userInput)
    {
        $produceValue = (new MomoTellerApi)->produce();
        return array_key_exists($userInput, $produceValue) ? $produceValue[$userInput] : false;
    }
}
