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
            'register' => [
                'confirm_farmer_name' =>['class' =>ConfirmFarmerName::class,'next' => 'select_type_of_crop'],
                'select_type_of_crop' =>['class' => SelectTypeOfCrop::class,'next'=>'select_quantity_of_last_safe'],
                'select_quantity_of_last_safe'=>['class' => SelectQuantityOfLastSafe::class,'next'=>'enter_location'],
                'enter_location'=>['class' =>Location::class,'next'=>'confirmation_messsage'],
                'confirmation_messsage' =>['class' => ConfirmationMessage::class,'next'=>''],
                'select_other_crop' =>['class' => SelectOtherCrop::class,'next'=>'select_quantity_of_last_safe'],
                'validation_screen'=>['class' => ValidationMessage::class,'next' => ''],
            ],

        ];
    }
}
