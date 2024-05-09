<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Abordage\HtmlMin\HtmlMin;

class MinifyHTMLMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (App::environment('production')) {
            $output = $response->getContent();
            $output = $this->minifyHTML($output);

            $response->setContent($output);
        }

        return $response;
    }

    /**
     * Minify the HTML content.
     *
     * @param  string  $html
     * @return string
     */
    protected function minifyHTML($html)
    {
        $htmlMinifier = new HtmlMin();
        return $htmlMinifier->minify($html);
    }
}
