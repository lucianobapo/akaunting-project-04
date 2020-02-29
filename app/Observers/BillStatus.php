<?php

namespace App\Observers;

use App\Models\Expense\BillStatus as Model;


class BillStatus extends TObserver
{
    public $modelClass = Model::class; 
}