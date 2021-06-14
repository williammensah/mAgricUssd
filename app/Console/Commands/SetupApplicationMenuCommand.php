<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupApplicationMenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates menu data for momo teller application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $menus = [
            [
                'name' => 'main_menu',
                'content' => "Welcome to  mAgric Farmer Onboarding" .PHP_EOL ."Are you a farmer".PHP_EOL. "1.Yes". PHP_EOL."2.No",
            ],
            [
                'name' => 'confirm_farmer_name',
                'content' => "Name : {name}".PHP_EOL."1. Confirm".PHP_EOL."2. Cancel",
            ],
            [
                'name' => 'select_type_of_crop',
                'content' => "Select type of crop".PHP_EOL."1.Cocoa" .PHP_EOL."2.Cashew".PHP_EOL."3.Coffee".PHP_EOL."4.Other",
            ],
            [
                'name' => 'select_other_crop',
                'content' => "Enter crop type".PHP_EOL,
            ],
            [
                'name' => 'select_quantity_of_last_safe',
                'content' => "Select quantity of last safe".PHP_EOL."1. 0 - 54kg ".PHP_EOL."2. 55 - 124kg".PHP_EOL."3. 125 - 254kg".PHP_EOL."4. 255 - 500kg".PHP_EOL."5. Greater than 500kg",
            ],
            [
                'name' => 'enter_location',
                'content' => "Enter location of your farm".PHP_EOL,
            ],
            [
                'name' => 'confirmation_messsage',
                'content' => "You have been successfully registered as a farmer".PHP_EOL."Thank you",
            ],
            [
                'name' => 'validation_screen',
                'content' => "{CustomValidationMessage}".PHP_EOL."1.Retry".PHP_EOL."2. Cancel",
            ],
            [
                'name' =>'main_menu2',
                'content'=>"{clerkName}".PHP_EOL."Total {total}".PHP_EOL."Balance:{balance}".PHP_EOL."1.Buy Produce".PHP_EOL."2.Give Advance".PHP_EOL."3.Purchase History".PHP_EOL."4.Buffer Check".PHP_EOL."5.Reset Pin",
            ],
            [
                'name' => 'main_menu3',
                'content' => "Welcome, {depotKeeper}".PHP_EOL."1.Evacuations".PHP_EOL."2.Reset Pin"
            ],
            [
                'name' => 'evacuations',
                'content' => "Evacuations".PHP_EOL."Enter Purchasing Clerk ID",
            ],
            [
                'name' => 'pending_evacuations',
                'content' => "{data}",
            ],
            [
                'name' => 'number_of_bags_to_evaculate',
                'content' => "{pendingEvacuation} pending evacuation".PHP_EOL."Enter number of bags to evacuate".PHP_EOL,
            ],
            [
                'name' => 'confirm_number_of_bags',
                'content' => "Confirm number of bags".PHP_EOL,
            ],
            [
                'name' => 'enter_way_bill_number',
                'content' => "Enter way bill number".PHP_EOL,
            ],
            [
                'name' => 'summary',
                'content' => "Produce: {produce}".PHP_EOL."Number of bags:{numberOfBags}".PHP_EOL."Way Bill:{wayBill}".PHP_EOL."1.Proceed".PHP_EOL."2.Cancel".PHP_EOL."0.Back",
            ],
            [
                'name' => 'evacuation_pin',
                'content' => "Enter pin".PHP_EOL,
            ],
            [
                'name' => 'evacuation_processing',
                'content' => "Evacuation processing ".PHP_EOL."You will receive a confirmation SMS shortly",
            ],
            [
                'name' =>'buy_produce',
                'content' =>"Select Produce".PHP_EOL."1.Cocoa".PHP_EOL."2.Coffee".PHP_EOL."3.Cashew",
            ],
            [
                'name' =>'enter_farmer_id_number',
                'content' =>"Enter Farmer's ID Number ".PHP_EOL."0.Back",
            ],
            [
                'name' =>'confirm_farmer_id_number',
                'content' =>"Confirm Farmer's ID Number ".PHP_EOL."0.Back",
            ],
            [
                'name' =>'farmer_data',
                'content' =>"Farmer Data".PHP_EOL."Name:{farmerName}".PHP_EOL."1.Confirm".PHP_EOL."0.Back",
            ],
            [
                'name' => 'enter_quantity_purchase',
                'content' => "Enter quantity to purchase in Kg".PHP_EOL."(Your current limit:12 Kg)".PHP_EOL."0.Back",
            ],
            [
                'name' => 'enter_pin',
                'content' => "{FarmerName}".PHP_EOL."{10}kg @ GHS{amount}".PHP_EOL."Total due {10}kg @ GHS{amount}".PHP_EOL."Enter your pin to confirm".PHP_EOL."0.Back",
            ],
            [
                'name' => 'advance_enter_pin',
                'content' => "{FarmerName}".PHP_EOL."Advance amount".PHP_EOL."GHS {amount}".PHP_EOL."Enter your pin to confirm".PHP_EOL."0.Back",
            ],
            [
                'name' => 'payment_processing',
                'content' => "Payment processing".PHP_EOL."You will receive a confirmation SMS shortly".PHP_EOL,
            ],
            [
                'name' => 'current_advance_limit',
                'content' => "Your Current Advance Limit:GHS{amount}".PHP_EOL."How much do you want to send ?.".PHP_EOL."0.Back",
            ],
            [
                'name' => 'buffer_check',
                'content' => "Your current buffer and commission balance is".PHP_EOL."GHS 520.00",
            ],
            [
                'name' => 'purchase_history',
                'content' => "Purchase History".PHP_EOL."{data}".PHP_EOL,
            ],
            [
                'name' => 'enter_current_pin',
                'content' => "Enter current PIN".PHP_EOL,
            ],
            [
                'name' => 'enter_new_pin',
                'content' => "Enter new PIN".PHP_EOL,
            ],
            [
                'name' => 'confirm_new_pin',
                'content' => "Confirm new PIN".PHP_EOL,
            ],
            [
                'name' => 'pin_reset_processing',
                'content' => "PIN reset processing".PHP_EOL."You will receive a confirmation SMS shortly",
            ],
        ];
        \DB::table('menus')->delete();
        \DB::table('menus')->insert($menus);
        Artisan::call('cache:clear');
        echo "<br>Done successfully. Cache cleared<br>";
        return "Done";
    }
}
