<?php

namespace App\Observers;

use App\Models\Setting\Category as Model;

class Category extends TObserver
{
    public $modelClass = Model::class; 
}