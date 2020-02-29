<?php

namespace App\Observers;

use App\Models\Income\InvoicePayment as Model;


class InvoicePayment extends TObserver
{
    public $modelClass = Model::class; 
}