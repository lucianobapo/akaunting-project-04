<?php

namespace App\Observers;

use App\Models\Module\Module as Model;


class Module extends TObserver
{
    public $modelClass = Model::class; 
}