<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CleanEmptyParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get all query parameters
        $queryParams = $request->query();

        // Filter out empty query parameters
        $filteredQueryParams = array_filter($queryParams, function ($value) {
            return $value !== '';
        });

        // If there are changes, redirect to the new URL without the empty parameters
        if (count($queryParams) !== count($filteredQueryParams)) {
            $newUrl = $request->url() . '?' . http_build_query($filteredQueryParams);
            return redirect($newUrl);
        }

        return $next($request);
    }
}
