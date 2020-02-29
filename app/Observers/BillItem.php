<?php

namespace App\Observers;

use App\Models\Expense\BillItem as Model;


class BillItem extends TObserver
{
    public $modelClass = Model::class; 
}