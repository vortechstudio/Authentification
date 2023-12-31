<?php
if (! function_exists('currentRouteActiveMenuHead')) {
    function currentRouteActiveMenuHead(...$routes)
    {
        foreach ($routes as $route) {
            if(Route::currentRouteNamed($route).".*") return 'active';
        }
    }
}
