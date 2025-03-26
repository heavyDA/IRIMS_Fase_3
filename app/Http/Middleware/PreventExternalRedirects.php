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

        // Add security headers
        $this->addSecurityHeaders($response);

        // Check if the response is a redirect
        if ($response instanceof RedirectResponse) {
            $urls = [$response->getTargetUrl(), $response->headers->get('Location')];
            foreach ($urls as $targetUrl) {
                // Validate the URL
                if (!$this->isSafeUrl($targetUrl)) {
                    // If not safe, redirect to dashboard instead
                    return redirect()->route('dashboard.index');
                }
            }
        }

        // Check if the response is a redirect
        if ($response->isRedirect()) {
            $targetUrl = $response->headers->get('Location');
            // Apply strict sanitization to prevent URL encoding bypasses
            $targetUrl = $this->sanitizeUrl($targetUrl);
            // If it's a relative URL without protocol-relative format, it's safe
            if ($this->isRelativeUrl($targetUrl)) {
                return $response;
            }

            // dd($targetUrl, !$this->isTrustedUrl($targetUrl));
            // If it's an absolute URL, check if it's pointing to a trusted host
            if (!$this->isTrustedUrl($targetUrl)) {
                // Log attempted redirect for security auditing
                \Illuminate\Support\Facades\Log::warning('Prevented external redirect attempt', [
                    'url' => $targetUrl,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
                // Redirect to home with error
                return redirect()->intended()->with('error', 'Unsafe redirect prevented');
            }
            // Set safe redirect URL back to response
            $response->headers->set('Location', $targetUrl);
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
        $response->headers->set('Content-Security-Policy', $this->buildCspPolicy());

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
     * Determine if the given URL is relative.
     *
     * @param  string  $url
     * @return bool
     */
    protected function isRelativeUrl(string $url): bool
    {
        // Check for protocol-relative URLs (//example.com) which are NOT safe
        if (str_starts_with($url, '//')) {
            return false;
        }

        // Standard protocols to check
        $protocols = ['http://', 'https://', 'ftp://', 'ftps://', 'mailto:', 'data:', 'file:', 'javascript:'];

        foreach ($protocols as $protocol) {
            if (str_starts_with(strtolower($url), $protocol)) {
                return false;
            }
        }

        // If URL starts with / (and not //) and doesn't contain ://, it's relative
        return str_starts_with($url, '/') || strpos($url, '://') === false;
    }

    /**
     * Determine if the given URL is pointing to a trusted host.
     *
     * @param  string  $url
     * @return bool
     */
    protected function isTrustedUrl(string $url): bool
    {
        // Parse URL strictly
        $parsedUrl = parse_url($url);

        if (!$parsedUrl || !isset($parsedUrl['host'])) {
            return false;
        }

        $host = strtolower($parsedUrl['host']);

        // Handle IP addresses specially
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            // Only allow specific IP addresses in the trusted hosts list
            return in_array($host, $this->trustedHosts);
        }

        // First check if it exactly matches a trusted host
        if (in_array($host, array_map('strtolower', $this->trustedHosts))) {
            return true;
        }

        // Then check for wildcard matches
        foreach ($this->trustedHosts as $trustedHost) {
            $trustedHost = strtolower($trustedHost);

            if (str_starts_with($trustedHost, '*.')) {
                $pattern = '/^(.+\.)?' . preg_quote(substr($trustedHost, 2), '/') . '$/i';
                if (preg_match($pattern, $host)) {
                    return true;
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
            "img-src 'self' data:; " .
            "style-src 'self' 'unsafe-inline'; " .
            "font-src 'self'; " .
            "script-src 'self' 'unsafe-eval' 'unsafe-inline'; " .
            "object-src 'none'; " .
            "frame-ancestors 'self'; " . // Anti-clickjacking: Only allow framing by same origin
            "base-uri 'self'; " .
            "form-action 'self';";
    }

    protected function isSafeUrl(string $url): bool
    {
        // If the URL is relative (starts with / or doesn't have a scheme), it's safe
        if (strlen($url) === 0 || $url[0] === '/' || !parse_url($url, PHP_URL_HOST)) {
            return true;
        }

        // Parse the URL
        $parsedUrl = parse_url($url);

        // Check if the host is in the allowed domains
        return isset($parsedUrl['host']) && in_array($parsedUrl['host'], $this->trustedHosts);
    }
}
