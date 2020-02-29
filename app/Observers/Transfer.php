<?php

namespace App\Observers;

use App\Models\Banking\Transfer as Model;


class Transfer extends TObserver
{
    public $modelClass = Model::class; 
}