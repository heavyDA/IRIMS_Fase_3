<?php

namespace App\Services\Nadia;

use App\Services\Nadia\Dto\NadiaResponse;
use Exception;
use Illuminate\Support\Facades\Http;

abstract class NadiaAbstract
{
    const SERVICE_NAME = 'Nadia Service';

    public function __construct(
        private ?string $host = null,
        private ?string $appId = null,
        private ?string $appKey = null,
        private ?string $token = null,
        public ?int $timeout = 10
    ) {}

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function getAppKey(): ?string
    {
        return $this->appKey;
    }

    public function getAppId(): ?string
    {
        return $this->appId;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function make_request(?string $path = null, array $payload, ?bool $single = false, ?array $headers = []): NadiaResponse
    {
        if ($path == null || $path == '') {
            throw new NadiaException('[' . self::class . '] Path cannot be null or empty.');
        }

        $request = Http::withoutVerifying()
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json')
            ->asForm()
            ->timeout($this->timeout);

        if ($headers) {
            foreach ($headers as $key => $value) {
                $request = $request->withHeader($key, $value);
            }
        }

        $request = $request->post($this->getHost() . $path, $payload);
        $response = NadiaResponse::fromArray($request->json());

        if (
            $request->failed() || $request->serverError() || $request->clientError() || $response->status == NadiaResponse::STATUS_ERROR
        ) {
            if (array_key_exists('password', $payload)) {
                unset($payload['password']);
            }

            $context = [
                'url' => (string) $request->effectiveUri(),
                'payload' => $payload,
                'response_code' => $request->status(),
                'response_body' => $request->body(),
            ];
            logger()->error(
                '[' . self::SERVICE_NAME . '] ' . ($response?->message ?? 'Failed to get data from Nadia Service.'),
                $context
            );
            throw new NadiaException(
                '[' . self::SERVICE_NAME . '] Failed to get data from ' . (string) $request->effectiveUri() . ' from Nadia Service. ' .
                    ($response->message ? "Error: {$response->message}" : ""),
                $request->status()
            );
        }

        return $response;
    }
}
