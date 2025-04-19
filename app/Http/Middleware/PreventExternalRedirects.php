<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventExternalRedirects
{
    /**
     * The trusted host patterns.
     *
     * @var array
     */
    protected $trustedHosts = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->trustedHosts = config('app.trusted_hosts');
        $response = $next($request);

        // Add security headers
        $this->addSecurityHeaders($response);

        // Check if the response is a redirect
        if ($response instanceof RedirectResponse) {
            $targetUrl = $response->getTargetUrl();

            // Apply strict sanitization to prevent URL encoding bypasses
            $targetUrl = $this->sanitizeUrl($targetUrl);

            // Check if the URL is safe (either relative or trusted host)
            if (!$this->isSafeUrl($targetUrl)) {
                // Log attempted redirect for security auditing
                \Illuminate\Support\Facades\Log::warning('Prevented external redirect attempt', [
                    'url' => $targetUrl,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                // Redirect to a known safe URL (dashboard or home)
                return redirect()->route('dashboard.index')
                    ->with('error', 'Unsafe redirect prevented');
            }

            // Set the sanitized URL back to the response
            $response->setTargetUrl($targetUrl);
        }

        return $response;
    }

    /**
     * Add security headers to the response.
     *
     * @param Response $response
     * @return void
     */
    protected function addSecurityHeaders(Response $response): void
    {
        // Set Content-Security-Policy header
        if (app()->environment('production')) {
            $response->headers->set('Content-Security-Policy', $this->buildCspPolicy());
        }

        // Anti-clickjacking headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // Allows framing by same origin only

        // Additional security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // Prevents MIME type sniffing
        $response->headers->set('X-XSS-Protection', '1; mode=block'); // Enables XSS filtering
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin'); // Controls referrer information

        // Strict Transport Security (only in production and if using HTTPS)
        if (app()->environment('production') && $response->isSuccessful()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
    }

    /**
     * Sanitize URL to prevent encoding bypasses.
     *
     * @param string $url
     * @return string
     */
    protected function sanitizeUrl(string $url): string
    {
        // Decode URL to prevent multiple encoding bypasses
        $decodedUrl = $url;
        $previousUrl = '';

        // Keep decoding until no more changes (handles multi-layered encoding)
        while ($decodedUrl !== $previousUrl) {
            $previousUrl = $decodedUrl;
            $decodedUrl = urldecode($previousUrl);
        }

        // Remove null bytes and other potentially dangerous characters
        $decodedUrl = str_replace(["\0", "\r", "\n", "\t", ' '], '', $decodedUrl);

        return $decodedUrl;
    }

    /**
     * Determine if the given URL is safe.
     *
     * @param  string|null  $url
     * @return bool
     */
    protected function isSafeUrl(?string $url): bool
    {
        // If URL is null or empty, consider it safe (will redirect to current URL)
        if (empty($url)) {
            return true;
        }

        // Parse the URL
        $parsedUrl = parse_url($url);

        // If the URL can't be parsed, it's not safe
        if ($parsedUrl === false) {
            return false;
        }

        // If there's no host component (relative URL), it's safe
        if (!isset($parsedUrl['host'])) {
            return true;
        }

        // Check for protocol-relative URLs that start with //
        if (
            !isset($parsedUrl['scheme']) && isset($parsedUrl['host']) &&
            strpos($url, '//') === 0
        ) {
            return in_array($parsedUrl['host'], $this->trustedHosts);
        }

        // Check for absolute URLs
        if (isset($parsedUrl['scheme']) && isset($parsedUrl['host'])) {
            // Only allow http and https schemes
            if (!in_array(strtolower($parsedUrl['scheme']), ['http', 'https'])) {
                return false;
            }

            // Check if the host is in our trusted hosts list
            // Use domain matching that handles subdomains
            return $this->isHostTrusted($parsedUrl['host']);
        }

        // If we get here, the URL format is unexpected
        return false;
    }

    /**
     * Check if a host is trusted by comparing against the trusted hosts list
     * with support for wildcard subdomains
     *
     * @param string $host
     * @return bool
     */
    protected function isHostTrusted(string $host): bool
    {
        // Convert host to lowercase for case-insensitive comparison
        $host = strtolower($host);

        foreach ($this->trustedHosts as $trustedHost) {
            // Check for exact match
            if ($host === strtolower($trustedHost)) {
                return true;
            }

            // Check for wildcard subdomain match
            if (strpos($trustedHost, '*.') === 0) {
                $domain = substr($trustedHost, 2); // Remove '*.'
                if (substr($host, -strlen($domain)) === $domain) {
                    // Make sure it's a subdomain, not a partial match elsewhere in the domain
                    if (
                        substr($host, 0, -strlen($domain)) === '' ||
                        substr($host, -strlen($domain) - 1, 1) === '.'
                    ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Build Content Security Policy.
     * 
     * @return string
     */
    protected function buildCspPolicy(): string
    {
        return "default-src 'self'; " .
            "img-src 'self' https://*.injourneyairports.id data:; " .
            "style-src 'self' 'unsafe-inline'; " .
            "font-src 'self'; " .
            "script-src 'self' 'unsafe-eval' 'unsafe-inline'; " .
            "object-src 'none'; " .
            // Uncomment this on development
            // "connect-src 'self' ws://localhost:5173; " .
            "frame-ancestors 'self'; " . // Anti-clickjacking: Only allow framing by same origin
            "base-uri 'self'; " .
            "form-action 'self';";
    }
}
