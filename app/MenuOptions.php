<?php

namespace App;

trait MenuOptions
{
    public $SEND_ECASH = 1;
    public $GET_ECASH = 2;
    public $CASH_DEPOSIT = 3;
    public $CASH_WITHDRAWAL = 4;
    public $HISTORY = 5;
    public $BACK = "0";

    public $CONFIRM = 1;
    public $CANCEL = 2;

    public $MAIN_MENU = 0;
    public $CHECK_TRANSACTION_STATUS = 1;
    public $REFRESH = 1;
    public $NEXT = 2;
    public $OTHERCROP = 4;

    public $BUY_PRODUCE = 1;
    public $GIVE_ADVANCE = 2;
    public $PURCHASE_HISTORY=3;
    public $BUFFER_CHECK=4;
    public $RESET_PIN=5;
    public $EVACUATION = 1;
    public $EVACUATION_PIN = 2;
}
