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
                'content' => "Welcome to <br>mAgric Farmer Onboarding<br>Are you a farmer ?. <br> 1.Yes<br> 2.No ",
            ],
            [
                'name' => 'confirm_farmer_name',
                'content' => "Name : {name} <br> <br>1. Confirm 2. Cancel<br>",
            ],
            [
                'name' => 'select_type_of_crop',
                'content' => "Select type of crop <br>1.Cocoa <br>2.Cashew <br> 3.Coffee <br> 4.Other ",
            ],
            [
                'name' => 'select_other_crop',
                'content' => "Enter crop type <br>",
            ],
            [
                'name' => 'select_quantity_of_last_safe',
                'content' => "Select quantity of last safe <br> <br>1. 0 - 54kg <br>2. 55 - 124kg<br>3. 125 - 254kg<br>4. 255 - 500kg<br>5. Greater than 500kg",
            ],
            [
                'name' => 'enter_location',
                'content' => "Enter location of your farm <br>",
            ],
            [
                'name' => 'confirmation_messsage',
                'content' => "You have been successfully registered as a farmer <br>.Thank you <br>",
            ],
        ];
        \DB::table('menus')->delete();
        \DB::table('menus')->insert($menus);
        Artisan::call('cache:clear');
        echo "<br>Done successfully. Cache cleared<br>";
        return "Done";
    }
}
