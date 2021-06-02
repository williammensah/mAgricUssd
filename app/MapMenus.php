<?php
namespace App;

use App\Menus\MainMenu;
use App\Menus\SubMenus\AccountNumber;
use App\Menus\SubMenus\ConfirmTransactionCashDeposit;
use App\Menus\SubMenus\ConfirmTransactionReceiveEcash;
use App\Menus\SubMenus\ConfirmTransactionSendEcash;
use App\Menus\SubMenus\EnterAgentPin;
use App\Menus\SubMenus\EnterAmount;
use App\Menus\SubMenus\EnterReference;
use App\Menus\SubMenus\MobileWalletNetwork;
use App\Menus\SubMenus\MobileWalletNumber;
use App\Menus\SubMenus\TransactionHistory;
use App\Menus\SubMenus\TransactionProcessing;
use App\Menus\SubMenus\ConfirmFarmerName;
use App\Menus\SubMenus\SelectTypeOfCrop;
use App\Menus\SubMenus\SelectQuantityOfLastSafe;
use App\Menus\SubMenus\Location;
use App\Menus\SubMenus\ConfirmationMessage;
use App\Menus\SubMenus\SelectOtherCrop;

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
                'select_other_crop' =>['class' => SelectOtherCrop::class,'next'=>'select_quantity_of_last_safe']
            ],
            'send_ecash' => [
                'mobile_wallet_network' => ['class' => MobileWalletNetwork::class, 'next' => 'enter_mobile_wallet_number'],
                'enter_mobile_wallet_number' => ['class' => MobileWalletNumber::class, 'next' => 'enter_amount'],
                'enter_amount' => ['class' => EnterAmount::class, 'next' => 'enter_reference'],
                'enter_reference' => ['class' => EnterReference::class, 'next' => 'confirm_transaction_send_ecash'],
                'confirm_transaction_send_ecash' => ['class' => ConfirmTransactionSendEcash::class, 'next' => 'enter_agent_pin'],
                'enter_agent_pin' => ['class' => EnterAgentPin::class, 'next' => 'transaction_processing'],
                'transaction_processing' => ['class' => TransactionProcessing::class, 'next' => 'transaction_history'],
                'transaction_history' => ['class' => TransactionHistory::class, 'next' => 'enter_mobile_wallet_number'],
            ],
            'get_ecash' => [
                'mobile_wallet_network' => ['class' => MobileWalletNetwork::class, 'next' => 'enter_mobile_wallet_number'],
                'enter_mobile_wallet_number' => ['class' => MobileWalletNumber::class, 'next' => 'enter_amount'],
                'enter_amount' => ['class' => EnterAmount::class, 'next' => 'enter_reference'],
                'enter_reference' => ['class' => EnterReference::class, 'next' => 'confirm_transaction_get_ecash'],
                'confirm_transaction_get_ecash' => ['class' => ConfirmTransactionReceiveEcash::class, 'next' => 'enter_agent_pin'],
                'enter_agent_pin' => ['class' => EnterAgentPin::class, 'next' => 'transaction_processing'],
                'transaction_processing' => ['class' => TransactionProcessing::class, 'next' => 'transaction_processing', 'customMessage' => 'Kindly prompt customer to wait for the prompt to authorise. An SMS will be sent once complete'],
            ],
            'cash_deposit' => [
                'enter_account_number' => ['class' => AccountNumber::class, 'next' => 'enter_amount'],
                'enter_amount' => ['class' => EnterAmount::class, 'next' => 'confirm_transaction_cash_deposit'],
                'confirm_transaction_cash_deposit' => ['class' => ConfirmTransactionCashDeposit::class, 'next' => 'enter_agent_pin'],
                'enter_agent_pin' => ['class' => EnterAgentPin::class, 'next' => 'transaction_processing'],
                'transaction_processing' => ['class' => TransactionProcessing::class, 'next' => 'transaction_processing', 'customMessage' => 'Please wait while we process your transaction. An SMS will be sent once completed'],
            ],
            'history' => [
                'transaction_history' => ['class' => TransactionHistory::class, 'next' => ''],
            ],
        ];
    }
}
