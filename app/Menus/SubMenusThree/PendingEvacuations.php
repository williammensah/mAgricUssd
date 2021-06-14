<?php

namespace App\Menus\SubMenusThree;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;
use App\ExternalServices\MomoTellerApi;

class PendingEvacuations extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'pending_evacuations';


    public function ask()
    {
        $output = $this->getDatafromApi();
        return $this->response($output, $this->menuName);
    }

    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|in:1,2,3'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for selecting a pending produce', [$validator->errors()]);
            $output = $this->getDatafromApi();
            return $this->response($output, $this->menuName);
        }
        $selectedEvacuation = $this->checkEvacuationValue(request()->userInput);
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['pendingEvacuation' => $selectedEvacuation]);
        return $this->nextScreen($state, $next);
    }


    private function checkEvacuationValue($userInput)
    {
        $pendingEvacuation = (new MomoTellerApi)->pendingEvacuation();
        return array_key_exists($userInput, $pendingEvacuation) ? $pendingEvacuation[$userInput] : false;
    }

    private function getDatafromApi()
    {
        $mAgricApi = new MomoTellerApi;
        $content = $this->getMenuContent('pending_evacuations');
        $pendingEvacuation = $mAgricApi->formatData($mAgricApi->pendingEvacuation());

        $output = str_replace(['{data}'], [$pendingEvacuation], $content);
        return $output;
    }
}
