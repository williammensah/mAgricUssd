<?php

namespace App\MenuTwoTraits;

use Cache;

trait MenuContentTwo
{
    protected $previousMenuKey;
    protected $menu = [];
    public function __construct()
    {
        $this->menu = Cache::rememberForever('menu2-cache', function () {
            return Menu::transformMenu();
        });
        $this->previousMenuKey = request()->msisdn . request()->sessionId . '.back';
    }
    public function invalidInput($message = null)
    {
        return $message ?? "Invalid Input";
    }
    public function getMenuContent($menuName = null): string
    {
        $this->setAsPreviousMenu();
        $message = $this->menu[$menuName ?? $this->menuName];
        return $this->properties['customMessage'] ?? $message;
    }

    public function setAsPreviousMenu()
    {
        if (Menu::isBackRequest()) {
            return;
        }
        Menu::setPreviousMenu();
    }
}
