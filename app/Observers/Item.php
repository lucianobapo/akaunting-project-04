<?php

namespace App\Observers;

use App\Models\Common\Item as Model;


class Item extends TObserver
{
    public $modelClass = Model::class; 
}