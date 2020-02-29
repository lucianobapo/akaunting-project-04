<?php

namespace App\Observers;

use App\Models\Common\Media as Model;


class Media extends TObserver
{
    public $modelClass = Model::class; 
}