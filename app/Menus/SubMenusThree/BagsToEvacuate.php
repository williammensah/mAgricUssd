<?php

namespace App\Menus\SubMenusThree;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;

class BagsToEvacuate extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'number_of_bags_to_evaculate';


    public function ask()
    {
        $output = $this->formatData();
        return $this->response($output, $this->menuName);
    }
    
    public function processUserInput($next, $state)
    {
        $validator = Validator::make(request()->all(), [
            'userInput' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            Log::info('Validator failed for entering number of bags', [$validator->errors()]);
            $content =  $this->formatData();
            $output = $this->prepend($content,$this->invalidInput());
             return $this->response($output, $this->menuName);
        }
        (new ClientState)->setState($next, request()->all(), $state['flow']);
        (new UserState)->store(['numberOfBags' => request()->userInput]);
        return $this->nextScreen($state, $next);
    }

    private function formatData()
    {
        $content = $this->getMenuContent('number_of_bags_to_evaculate');
        $userState = (new UserState)->getState();
        $data = explode(" ",$userState['pendingEvacuation']);
        array_push($data,$data[0]);
        array_splice($data,0,1);

        $data =  implode(' ',$data);
        $output = str_replace(['{pendingEvacuation}'], [$data], $content);
        return $output;
    }
}
