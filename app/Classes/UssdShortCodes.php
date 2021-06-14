<?php

namespace App\Classes;

use App\Http;
use Cache;
use Log;
use Illuminate\Support\Env;
use App\Menus\MainMenu;
use App\Menus\MainMenuTwo;

class UssdShortCodes
{
    public function routeMainMenu()
    {
        if (request()->requestType === 'INITIATION') {
            Log::info('New Session Start', [request()->all()]);
            switch (request()->shortCode ) {
                case env('MENU1_USSD_SHORT_CODE'):
                    Log::info("logging ussd shortcode for menu1", [request()->shortCode]);
                    return (new MainMenu)->index();
                    break;
                case env('MENU2_USSD_SHORT_CODE'):
                    Log::info("logging ussd shortcode for menu2", [request()->shortCode]);
                    return (new MainMenuTwo)->index();
                    break;
                default:
                    Log::error('Something went wrong with request');
                 return response("Sorry an error occured!.Invalid shortcode.", 500);
            }
        }
        return false;
        // return response("Sorry an error occured!. Please try again later.", 500);
    }
}
