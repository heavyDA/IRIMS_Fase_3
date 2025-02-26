<?php

namespace App\Services\EOffice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class UnitService extends EOfficeAbstract
{
    public function __construct(?string $host, ?string $token)
    {
        parent::__construct($host, $token);
    }

    protected function replace_id_with_code(string $value): string
    {
        return str_replace('_id', '_code', $value);
    }

    protected function transform_key(array $item): object
    {
        return (object) [
            'unit_code' => $item['supervision_unit_id'],
            'unit_code_doc' => $item['supervision_unit_code_doc'],
            'unit_name' => $item['supervision_unit_name'],
            'unit_position_name' => $item['supervision_position_name'],
            'sub_unit_code' => $item['unit_id'],
            'sub_unit_code_doc' => $item['unit_code_doc'],
            'sub_unit_name' => $item['unit_name'],
            'branch_code' => $item['branch_code'],
            'regional_category' => $item['regional_category'],
            'position_name' => $item['position_name'],
        ];
    }

    public function get_by_id(?string $unit_code = null): ?object
    {
        return Cache::remember('unit.' . $unit_code, now()->addMinutes(5), function () use ($unit_code) {
            return $this->transform_key($this->make_request('all_unit', ['unit_id' => $unit_code], true));
        });
    }

    public function get_all(): Collection
    {
        return Cache::remember('units', now()->addMinutes(5), function () {
            $data = collect($this->make_request('all_unit', [], false));
            if (empty($data)) {
                return collect([]);
            }

            foreach ($data as $index => $item) {
                $data[$index] = $this->transform_key($item);
            }

            return collect($data);
        });
    }

    public function get_by_branch_code(?string $branch_code = null): Collection
    {
        return Cache::remember('branch_code.' . $branch_code, now()->addMinutes(5), function () use ($branch_code) {
            $data = collect($this->make_request('all_unit', ['branch_code' => $branch_code], false));
            if (empty($data)) {
                return collect([]);
            }

            foreach ($data as $index => $item) {
                $data[$index] = $this->transform_key($item);
            }

            return collect($data);
        });
    }

    public function get_by_regional_category(?int $regional_category = null): Collection
    {
        return Cache::remember('regional_category.' . $regional_category, now()->addMinutes(5), function () use ($regional_category) {
            $data = collect($this->make_request('all_unit', ['regional_category' => $regional_category], false));
            if (empty($data)) {
                return collect([]);
            }

            foreach ($data as $index => $item) {
                $data[$index] = $this->transform_key($item);
            }

            return collect($data);
        });
    }

    public function get_supervised(?string $unit_code = null): Collection
    {
        return Cache::remember('supervised_units.' . $unit_code, now()->addMinutes(5), function () use ($unit_code) {
            $data = collect($this->make_request('all_unit', ['supervision_unit_id' => $unit_code], false));
            if (empty($data)) {
                return collect([]);
            }

            foreach ($data as $index => $item) {
                $data[$index] = $this->transform_key($item);
            }

            return collect($data);
        });
    }

    public function get_supervised_with_children(?string $unit_code = null): Collection
    {
        return Cache::remember('supervised_units.' . $unit_code, now()->addMinutes(5), function () use ($unit_code) {
            $data = collect($this->make_request('all_unit', ['supervision_unit_id' => $unit_code], false));
            if (empty($data)) {
                return collect([]);
            }

            foreach ($data as $index => $item) {
                $data[$index] = $this->transform_key($item);
            }

            return collect($data);
        });
    }

    public function get_supervised_recursively(?string $unit_code = null): Collection
    {
        return Cache::remember('supervised_units_recursively.' . $unit_code, now()->addMinutes(5), function () use ($unit_code) {
            $data = collect($this->make_request('all_unit', ['supervision_unit_id' => $unit_code], false));
            if (empty($data)) {
                return collect([]);
            }

            $items = [];
            foreach ($data as $item) {
                foreach ($item as $key => $value) {
                    $item[$this->replace_id_with_code(strtolower($key))] = $value;
                }
                $items[] = (object) $item;
            }

            return collect($items);
        });
    }
}
