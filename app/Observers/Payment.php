<?php

namespace App\Observers;

use App\Models\Expense\Payment as Model;


class Payment extends TObserver
{
    public $modelClass = Model::class; 
}