<?php

namespace App\Utilities;

use Closure;

class CacheUtility
{    
    protected $cache_minutes = 60 * 24;

    public function remember($key, Closure $callback, $tag = 'default')
    {
        $tag = $this->prepareTags($tag);
        
        return cache()->tags($tag)->remember(session('company_id').$key.md5($_SERVER['QUERY_STRING']), $this->cache_minutes, function () use ($callback){
            $return = $callback();
            return is_null($return)?[]:$return;
        });
    }

    public function flush()
    {
        cache()->flush();
    }

    public function flushTag($tag)
    {
        $tag = $this->prepareTags($tag);
        cache()->tags($tag)->flush();
    }

    protected function prepareTags($tags)
    {
        if (is_array($tags)){
            foreach ($tags as $key => $tag) {
                $tags[$key] = $this->arrangeTag($tag);
            }
        } else $tags = $this->arrangeTag($tags);
        return $tags;
    }

    protected function arrangeTag($tag)
    {
        if (strlen($tag)>1 && (substr($tag,0,1-strlen($tag))=='\\')){
            $tag = substr($tag,1,strlen($tag));
            return $tag;
        }
        return $tag;
    }
}