<?php

namespace App\Services\EOffice;

use Exception;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

abstract class EOfficeAbstract
{
    public function __construct(
        private ?string $host = null,
        private ?string $token = null
    ) {
        $this->host = $host;
        $this->token = $token;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function make_request(?string $path = null, array $payload, ?bool $single = false): array
    {
        if ($path == null || $path == '') {
            throw new Exception('[' . self::class . '] Path cannot be null or empty.');
        }

        $request = Http::withoutVerifying()
            ->withHeader('Authorization', $this->getToken())
            ->asForm()
            ->timeout(10)
            ->post($this->getHost() . $path, $payload);

        if ($request->failed() || $request->serverError() || $request->clientError()) {
            throw new Exception('[' . self::class . '] Failed to get data ' . $path . ' from E Office Service. ' . $request->body(), $request->status(), $request->toException());
        }

        if (empty($request->json()['data'])) {
            return [];
        }

        return $single ? $request->json()['data'][0] : $request->json()['data'];
    }

    public function make_pool_request(?string $path = null, array $payloads): object
    {
        if ($path == null || $path == '') {
            throw new Exception('[' . self::class . '] Path cannot be null or empty.');
        }

        $data = collect();
        $requests = Http::pool(function (Pool $pool) use ($path, $payloads) {
            $pools = [];

            foreach ($payloads as $payload) {
                $pool->withoutVerifying()
                    ->asForm()
                    ->timeout(10)
                    ->post($this->getHost() . $path, $payload);
            }

            return $pools;
        });

        foreach ($requests as $request) {
        }


        return collect([]);
    }
}
