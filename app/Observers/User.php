<?php

namespace App\Observers;

use App\Models\Auth\User as Model;


class User extends TObserver
{
    public $modelClass = Model::class; 
}