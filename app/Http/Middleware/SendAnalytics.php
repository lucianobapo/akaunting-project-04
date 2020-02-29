<?php

namespace App\Http\Middleware;

use Closure;

class SendAnalytics {

    public function __construct() {
        start_measure('render','Time for rendering');
    }

    public function handle($request, Closure $next) {
    	stop_measure('render');
        return $next($request);
    }

    public function terminate($request, $response) {
        
    }
}