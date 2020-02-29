<?php

namespace App\Observers;

use App\Models\Model;
use App\Utilities\CacheUtility;

class TObserver
{
    public $modelClass = Model::class;
    public $cache;

    public function __construct(CacheUtility $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Listen to the created event.
     *
     * @param  Model $model
     *
     * @return void
     */
    public function created($model)
    {   
        $this->cache->flushTag($this->modelClass);
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model $model
     *
     * @return void
     */
    public function deleted($model)
    {
        $this->cache->flushTag($this->modelClass);
    }

    /**
     * Listen to the updated event.
     *
     * @param  Model $model
     *
     * @return void
     */
    public function updated($model)
    {        
        $this->cache->flushTag($this->modelClass);
    }

}