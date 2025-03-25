<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventExternalRedirects
{
    /**
     * The trusted host patterns.
     *
     * @var array
     */
    protected $trustedHosts = [
        // Add your application's domains here
        'localhost',
        '127.0.0.1',
        'sierina.injourneyairports.id',
        // Example: 'example.com',
        // Example: '*.example.com',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if the response is a redirect
        if ($response->isRedirect()) {
            $targetUrl = $response->headers->get('Location');

            // If it's a relative URL, it's safe
            if ($this->isRelativeUrl($targetUrl)) {
                return $response;
            }

            // If it's an absolute URL, check if it's pointing to a trusted host
            if (!$this->isTrustedUrl($targetUrl)) {
                // Redirect to home or throw an exception
                return redirect('/')->with('error', 'Unsafe redirect prevented');

                // Alternative: Throw an exception
                // abort(403, 'Unsafe redirect prevented');
            }
        }

        return $response;
    }

    /**
     * Determine if the given URL is relative.
     *
     * @param  string  $url
     * @return bool
     */
    protected function isRelativeUrl(string $url): bool
    {
        // If URL starts with / or doesn't contain ://, it's relative
        return strpos($url, '://') === false || str_starts_with($url, '/');
    }

    /**
     * Determine if the given URL is pointing to a trusted host.
     *
     * @param  string  $url
     * @return bool
     */
    protected function isTrustedUrl(string $url): bool
    {
        $parsedUrl = parse_url($url);

        if (!$parsedUrl || !isset($parsedUrl['host'])) {
            return false;
        }

        $host = $parsedUrl['host'];

        // First check if it exactly matches a trusted host
        if (in_array($host, $this->trustedHosts)) {
            return true;
        }

        // Then check for wildcard matches
        foreach ($this->trustedHosts as $trustedHost) {
            if (str_starts_with($trustedHost, '*.')) {
                $pattern = '/^(.+\.)?' . preg_quote(substr($trustedHost, 2), '/') . '$/i';
                if (preg_match($pattern, $host)) {
                    return true;
                }
            }
        }

        return false;
    }
}
