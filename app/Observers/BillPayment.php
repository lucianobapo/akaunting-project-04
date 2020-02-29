<?php

namespace App\Observers;

use App\Models\Expense\BillPayment as Model;


class BillPayment extends TObserver
{
    public $modelClass = Model::class; 
}