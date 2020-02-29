<?php

namespace App\Observers;

use App\Models\Expense\Bill as Model;

class Bill extends TObserver
{
    public $modelClass = Model::class; 
}