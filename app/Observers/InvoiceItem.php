<?php

namespace App\Observers;

use App\Models\Income\InvoiceItem as Model;


class InvoiceItem extends TObserver
{
    public $modelClass = Model::class; 
}