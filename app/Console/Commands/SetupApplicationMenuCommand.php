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
        ];
        \DB::table('menus')->delete();
        \DB::table('menus')->insert($menus);
        Artisan::call('cache:clear');
        echo "<br>Done successfully. Cache cleared<br>";
        return "Done";
    }
}
