<?php

namespace App\Menus\SubMenusTwo;

use App\ScreenSession;
use App\State\ClientState;
use App\State\UserState;
use Log;
use validator;
use App\ExternalServices\MomoTellerApi;

class PurchaseHistory extends ScreenSession
{
    /* You ask with the current menu name.
    eg. return Mobilenumber::ask(), current menu returned = enter_mobile_number
     */

    public $menuName = 'purchase_history';

    public function ask()
    {
        $data =  (new MomoTellerApi)->getPurchasingClerkHistory()['data'];
        $history = 'No History data';
         if ($data) {
            $history = $this->prepareHistory($data);
         }

         $content = $this->getMenuContent('purchase_history');
        $output = str_replace('{data}',$history,$content);
        return $this->response($output, $this->menuName);
    }

    public function prepareHistory($data)
    {
        $count = count($data);
        $history = '';
        for ($i = 1; $i < $count; $i++) {
            $history .= $i.' '.$data[$i]['clerk_phone_number'] . '-' . date('Y/m/d H:i', strtotime($data[$i]['created_at'])) .'-'.$data[$i]['bags'].'kg'.PHP_EOL;
        }
        return $history;
    }


}
