<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupApplicationMenuTwoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu2:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates menu2 data for mAgric Ussd Application';

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
                'name' =>'Select Produce',
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
                'content' => "{FarmerName}".PHP_EOL."{10kg} @ GHS{amount}".PHP_EOL."Total due {10kg} @ GHS{amount}".PHP_EOL."Enter your pin to confirm".PHP_EOL."0.Back",
            ],
            [
                'name' => 'payment_processing',
                'content' => "Payment processing".PHP_EOL."You will receive a confirmation".PHP_EOL."SMS shortly",
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
                'content' => "Purchase History".PHP_EOL,
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
        \DB::table('menus_two')->delete();
        \DB::table('menus_two')->insert($menus);
        Artisan::call('cache:clear');
        echo "<br>Done successfully. Cache cleared<br>";
        return "Done";
    }
}
