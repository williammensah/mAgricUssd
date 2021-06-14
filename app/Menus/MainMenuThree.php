<?php

namespace App\Menus;

use App\ExternalServices\MomoTellerApi;
use App\MenuOptions;
use App\Responses;
use App\State\ClientState;
use App\State\UserState;
use Log;
use Validator;
use App\MenuContent;
use App\Menus\SubMenusThree\Evacuation;
use App\Menus\SubMenusTwo\EnterCurrentPin;

class MainMenuThree
{
    use MenuOptions, MenuContent,Responses;
    public function index()
    {
        $clientState = new ClientState;
        $userState = new UserState;
        $this->refreshSession($clientState, $userState);
        $clientState->setState('main_menu3', request()->all(), 'main_menu3');
        $response = (new MomoTellerApi)->evacuationUser()['data'];
        //check permissions here below
        $content = $this->getMenuContent('main_menu3');
        $output = str_replace('{depotKeeper}',$response['name'], $content);
        $userState->store($response);
        return $this->response($output, 'main_menu3');
    }


    public function fire($state = null, $next = null, $data = null)
    {
        Log::info('MainMenu 3 Fired', ['state' => $state, 'next' => $next]);
        $state = new ClientState;

        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|in:1,2'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed invalid menu option selected', [$validator->errors()]);
            return $this->index();
        }


        if (request()->userInput == $this->EVACUATION) {
            $flow = 'evacuations';
            $next = 'evacuations';
            $state->setState($next, request()->all(), $flow);
            return (new Evacuation)->fire($state);
        }

        if (request()->userInput == $this->EVACUATION_PIN) {
            $flow = 'reset_pin';
            $next = 'enter_current_pin';
            $state->setState($next, request()->all(), $flow);
            return (new EnterCurrentPin)->fire($state);
        }
        if ($next && $next === 'main_menu3' || $next === 'ROOT') {
            return $this->index();
        }
        return "Invalid Input";
    }


    public function refreshSession($clientState, $userState)
    {
        $userState->clearState();
        $clientState->clearState();
    }
}
