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
use App\Menus\SubMenusTwo\BuyProduce;
use App\Menus\SubMenusTwo\EnterFarmerIdNumber;
use App\Menus\SubMenusTwo\BufferCheck;
use App\Menus\SubMenusTwo\PurchaseHistory;
use App\Menus\SubMenusTwo\PinResetProcessing;
use App\Menus\SubMenusTwo\EnterCurrentPin;
use App\Menus\MainMenuThree;

class MainMenuTwo
{
    use MenuOptions, MenuContent,Responses;
    public function index()
    {
        $clientState = new ClientState;
        $userState = new UserState;
        $this->refreshSession($clientState, $userState);
        $clientState->setState('main_menu2', request()->all(), 'main_menu2');
        $response = (new MomoTellerApi)->lookUpPurchasingClerk(request()->msisdn);
        //check permissions here below
       if (request()->msisdn === '0201991407') {
           return ( new MainMenuThree)->index();
        }

        if (!$response) {
            return $this->endSession("You are not authorised to access this service!", 'main_menu');
        }
        $content = $this->getMenuContent('main_menu2');
        $output = str_replace(['{clerkName}','{total}','{balance}'], [$response['name'], $response['total'],$response['balance']], $content);
        $userState->store($response);
        return $this->response($output, 'main_menu2');
    }


    public function fire($state = null, $next = null, $data = null)
    {
        Log::info('Main Menu Fired', ['state' => $state, 'next' => $next]);
        $state = new ClientState;

        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|in:1,2,3,4,5'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed invalid menu option selected', [$validator->errors()]);
            return $this->index();
        }


        if (request()->userInput == $this->BUY_PRODUCE) {
            $flow = 'buy_produce';
            $next = 'buy_produce';
            $state->setState($next, request()->all(), $flow);
            return (new BuyProduce)->fire($state);
        }

        if (request()->userInput == $this->GIVE_ADVANCE) {
            $flow = 'give_advance';
            $next = 'enter_farmer_id_number';
            $state->setState($next, request()->all(), $flow);
            return (new EnterFarmerIdNumber)->fire($state);
        }

        if (request()->userInput == $this->PURCHASE_HISTORY) {
            $flow = 'purchase_history';
            $next = 'purchase_history';
            $state->setState($next, request()->all(), $flow);
            return (new PurchaseHistory)->fire($state);
        }

        if (request()->userInput == $this->BUFFER_CHECK) {
            $flow = 'buffer_check';
            $next = 'buffer_check';
            $state->setState($next, request()->all(), $flow);
            return (new BufferCheck)->fire($state);
        }

        if (request()->userInput == $this->RESET_PIN) {
            $flow = 'reset_pin';
            $next = 'enter_current_pin';
            $state->setState($next, request()->all(), $flow);
            return (new EnterCurrentPin)->fire($state);
        }
        if ($next && $next === 'main_menu2' || $next === 'ROOT') {
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
