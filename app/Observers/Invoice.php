<?php

namespace App\Observers;

use App\Models\Income\Invoice as Model;


class Invoice extends TObserver
{
    public $modelClass = Model::class; 
}