<?php

namespace App\Observers;

use App\Models\Income\Revenue as Model;


class Revenue extends TObserver
{
    public $modelClass = Model::class; 
}