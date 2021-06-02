<?php

namespace App\Menus;

use App\ExternalServices\MomoTellerApi;
use App\MenuContent;
use App\MenuOptions;
use App\Menus\SubMenus\AccountNumber;
use App\Menus\SubMenus\MobileWalletNetwork;
use App\Menus\SubMenus\TransactionHistory;
use App\Responses;
use App\State\ClientState;
use App\State\UserState;
use Log;
use App\Menus\SubMenus\ConfirmFarmerName;

class MainMenu
{
    use MenuOptions, MenuContent, Responses;
    public function index()
    {
        $clientState = new ClientState;
        $userState = new UserState;
        $this->refreshSession($clientState, $userState);
        $clientState->setState('main_menu', request()->all(), 'main_menu');
        $response = (new MomoTellerApi)->lookupAgent(request()->msisdn);
        if (!$response) {
            return $this->endSession("You are not authorised to access this service!", 'main_menu');
        }
        $userState->store($response);
        $content = $this->getMenuContent('main_menu');
        return $this->response($content,'main_menu');
    }
    public function fire($state = null, $next = null, $data = null)
    {
        Log::info('Main Menu Fired', ['state' => $state, 'next' => $next]);
        $state = new ClientState;
        if (request()->userInput == $this->SEND_ECASH) {
            $flow = 'register';
            $next = 'confirm_farmer_name';
            $state->setState($next, request()->all(), $flow);
            return (new ConfirmFarmerName)->fire($state);
        }
    
        if ($next && $next === 'main_menu' || $next === 'ROOT') {
            return $this->index();
        }
        return "Invalid Input";
    }public function refreshSession($clientState, $userState)
    {
        $userState->clearState();
        $clientState->clearState();
    }
}
