<?php

namespace App\Observers;

use App\Models\Expense\Vendor as Model;


class Vendor extends TObserver
{
    public $modelClass = Model::class; 
}