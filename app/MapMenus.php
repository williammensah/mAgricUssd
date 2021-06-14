<?php

namespace App;

use App\Menus\MainMenu;

use App\Menus\SubMenus\ConfirmFarmerName;
use App\Menus\SubMenus\SelectTypeOfCrop;
use App\Menus\SubMenus\SelectQuantityOfLastSafe;
use App\Menus\SubMenus\Location;
use App\Menus\SubMenus\ConfirmationMessage;
use App\Menus\SubMenus\SelectOtherCrop;
use App\Menus\SubMenus\ValidationMessage;
use App\Menus\SubMenusTwo\BuyProduce;
use App\Menus\MainMenuTwo;
use App\Menus\SubMenusTwo\EnterFarmerIdNumber;
use App\Menus\SubMenusTwo\ConfirmFarmerIdNumber;
use App\Menus\SubMenusTwo\FarmerData;
use App\Menus\SubMenusTwo\QuantityToPurchase;
use App\Menus\SubMenusTwo\EnterPin;
use App\Menus\SubMenusTwo\PaymentProcessing;
use App\Menus\SubMenusTwo\CurrentAdvanceLimit;
use App\Menus\SubMenusTwo\PurchaseHistory;
use App\Menus\SubMenusTwo\BufferCheck;
use App\Menus\SubMenusTwo\EnterCurrentPin;
use App\Menus\SubMenusTwo\EnterNewPin;
use App\Menus\SubMenusTwo\ConfirmNewPin;
use App\Menus\SubMenusTwo\PinResetProcessing;
use App\Menus\SubMenusTwo\AdvanceEnterPin;
use App\Menus\MainMenuThree;
use App\Menus\SubMenusThree\Evacuation;
use App\Menus\SubMenusThree\PendingEvacuations;
use App\Menus\SubMenusThree\BagsToEvacuate;
use App\Menus\SubMenusThree\NumberOfBags;
use App\Menus\SubMenusThree\WayBillNumber;
use App\Menus\SubMenusThree\Summary;
use App\Menus\SubMenusThree\EvacuationPin;
use App\Menus\SubMenusThree\EvacuationProcessing;

trait MapMenus
{
    use MenuContent;
    public function goToMainMenu()
    {
        return (new MainMenu)->index();
    }
    public function mapToMenu($state, $next, $data = null)
    {
        $menu = $this->getMappings()[$state['flow']][$next];
        return (new $menu['class'])->fire($state, $menu, $data);
    }
    protected function getMappings()
    {
        return [
            'main_menu' => [
                'main_menu' => ['class' => MainMenu::class, 'next' => null],
                'ROOT' => ['class' => MainMenu::class, 'next' => null],
            ],
            'main_menu2' => [
                'main_menu2' => ['class' => MainMenuTwo::class, 'next' => null],
                'ROOT' => ['class' => MainMenuTwo::class, 'next' => null],
            ],
            'main_menu3' => [
                'main_menu3' => ['class' => MainMenuThree::class, 'next' => null],
                'ROOT' => ['class' => MainMenuThree::class, 'next' => null],
            ],
            'register' => [
                'confirm_farmer_name' => ['class' => ConfirmFarmerName::class, 'next' => 'select_type_of_crop'],
                'select_type_of_crop' => ['class' => SelectTypeOfCrop::class, 'next' => 'select_quantity_of_last_safe'],
                'select_quantity_of_last_safe' => ['class' => SelectQuantityOfLastSafe::class, 'next' => 'enter_location'],
                'enter_location' => ['class' => Location::class, 'next' => 'confirmation_messsage'],
                'confirmation_messsage' => ['class' => ConfirmationMessage::class, 'next' => ''],
                'select_other_crop' => ['class' => SelectOtherCrop::class, 'next' => 'select_quantity_of_last_safe'],
                'validation_screen' => ['class' => ValidationMessage::class, 'next' => ''],
            ],
            'buy_produce' => [
                'buy_produce' => ['class' => BuyProduce::class, 'next' => 'enter_farmer_id_number'],
                'enter_farmer_id_number' => ['class' => EnterFarmerIdNumber::class, 'next' => 'confirm_farmer_id_number'],
                'confirm_farmer_id_number' => ['class' => ConfirmFarmerIdNumber::class, 'next' => 'farmer_data'],
                'farmer_data' => ['class' => FarmerData::class, 'next' => 'enter_quantity_purchase'],
                'enter_quantity_purchase' => ['class' => QuantityToPurchase::class, 'next' => 'enter_pin'],
                'enter_pin' => ['class' => EnterPin::class, 'next' => 'payment_processing'],
                'payment_processing' => ['class' => PaymentProcessing::class, 'next' => '']
            ],
            'give_advance' =>[
                'enter_farmer_id_number' => ['class' =>EnterFarmerIdNumber::class,'next'=>'farmer_data'],
                'farmer_data' =>['class' =>FarmerData::class,'next'=>'current_advance_limit'],
                'current_advance_limit'=>['class'=>CurrentAdvanceLimit::class,'next'=>'advance_enter_pin'],
                'advance_enter_pin' =>['class'=>AdvanceEnterPin::class,'next'=>'payment_processing'],
                'payment_processing'=>['class'=>PaymentProcessing::class,'next'=>'']
            ],
            'purchase_history' =>[
                'purchase_history'=> ['class' =>PurchaseHistory::class,'next'=>'']
            ],
            'buffer_check' => [
                'buffer_check' => ['class' =>BufferCheck::class,'next'=>'buffer_check']
            ],
            'reset_pin' => [
                'enter_current_pin' =>['class' =>EnterCurrentPin::class,'next' =>'enter_new_pin'],
                'enter_new_pin' => ['class' =>EnterNewPin::class,'next' =>'confirm_new_pin'],
                'confirm_new_pin' =>['class' =>ConfirmNewPin::class,'next' => 'pin_reset_processing'],
                'pin_reset_processing'=> ['class' =>PinResetProcessing::class,'next' =>'']
            ],
            'evacuations' => [
                'evacuations' =>['class' =>Evacuation::class,'next' =>'pending_evacuations'],
                'pending_evacuations' => ['class' => PendingEvacuations::class,'next' =>'number_of_bags_to_evaculate'],
                'number_of_bags_to_evaculate' =>['class' =>BagsToEvacuate::class,'next' => 'confirm_number_of_bags'],
                'confirm_number_of_bags'=> ['class' =>NumberOfBags::class,'next' =>'enter_way_bill_number'],
                'enter_way_bill_number' =>['class' =>WayBillNumber::class,'next' => 'summary'],
                'summary'=> ['class' =>Summary::class,'next' =>'evacuation_pin'],
                'evacuation_pin'=> ['class' =>EvacuationPin::class,'next' =>'evacuation_processing'],
                'evacuation_processing' =>['class' =>EvacuationProcessing::class,'next' => ''],
            ]
        ];
    }
}
