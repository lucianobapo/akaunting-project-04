<?php

namespace App\Observers;

use App\Models\Setting\Tax as Model;


class Tax extends TObserver
{
    public $modelClass = Model::class; 
}