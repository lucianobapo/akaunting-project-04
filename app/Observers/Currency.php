<?php

namespace App\Observers;

use App\Models\Setting\Currency as Model;

class Currency extends TObserver
{
    public $modelClass = Model::class; 
}