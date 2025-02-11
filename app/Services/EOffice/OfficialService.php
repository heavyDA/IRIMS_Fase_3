<?php

namespace App\Services\EOffice;

use Illuminate\Support\Facades\Cache;

class OfficialService extends EOfficeAbstract
{
    public function __construct(?string $host, ?string $token)
    {
        parent::__construct($host, $token);
    }

    public function get(?string $unit_code): object
    {
        return Cache::remember('officials.' . $unit_code, now()->addMinutes(5), function () use ($unit_code) {
            $data = $this->make_request('pejabat_get', ['organization_code' => $unit_code, 'effective_date' => Date('Y'). '-01-06'], true);

            if (empty($data)) {
                return (object) [];
            }

            $item = [];
            foreach ($data as $key => $value) {
                $item[strtolower($key)] = $value;
            }

            return (object) $item;
        });
    }

    public function get_all(): object
    {
        return Cache::remember('officials', now()->addMinutes(5), function () {
            $data = $this->make_request('pejabat_get', ['effective_date' => Date('Y'). '-01-06']);

            if (empty($data)) {
                return collect([]);
            }

            $items = [];
            foreach ($data as $item) {

                $_item = [];
                foreach ($item as $key => $value) {
                    $_item[strtolower($key)] = $value;
                }

                $items[] = (object) $_item;
            }

            return collect($items);
        });
    }
}
