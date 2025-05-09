<?php

use App\Enums\State;
use Carbon\Carbon;

if (!function_exists('format_date')) {
    function format_date(string $date): Carbon
    {
        return Carbon::parse($date)->setTimezone(get_current_timezone());
    }
}

if (!function_exists('string_to_float')) {
    function string_to_float(string $string): float
    {
        if (is_numeric($string)) {
            return (float) $string;
        }

        return 0;
    }
}

if (!function_exists('array_remove_empty')) {
    function array_remove_empty(array $array): array
    {
        return array_filter($array, fn($value) => $value !== null && $value !== '');
    }
}

if (!function_exists('array_set_empty_string_to_null')) {
    function array_set_empty_string_to_null(array $array): array
    {
        return array_map(fn($value) => $value === '' ? null : $value, $array);
    }
}

if (!function_exists('is_timezone_available')) {
    function is_timezone_available(?string $timezone): bool
    {
        return in_array($timezone, timezone_identifiers_list(DateTimeZone::PER_COUNTRY, countryCode: 'ID'));
    }
}

if (!function_exists('is_associative_array')) {
    function is_associative_array(array $array): bool
    {
        if (empty($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}

if (!function_exists('month_quarter')) {
    function month_quarter(?string $date = null): string
    {
        if (!$date) {
            $date = date('Y-m-d');
        }

        $date = Carbon::parse($date);
        $quarter = ceil($date->format('n') / 3);

        return $quarter;
    }
}

if (!function_exists('flash_message')) {
    /**
     * @param string $message
     * @param string $type
     *
     * @return void
     */
    function flash_message(string $name = 'flash_message', string $message = '', State $type = State::SUCCESS): void
    {
        session()->flash($name, ['message' => $message, 'type' => $type]);
    }
}

if (!function_exists('money_format')) {
    function money_format($value = 0, $prefix = 'Rp.')
    {
        return $prefix . number_format($value, 2, ',', '.');
    }
}

if (!function_exists('string_to_bool')) {
    function string_to_bool(?string $string = ''): bool|null
    {
        if (strtolower($string) == 'pilih' || !in_array($string, ['0', '1', 0, 1])) {
            return null;
        }
        return (bool) $string;
    }
}

if (!function_exists('check_select_option_value')) {
    function check_select_option_value(?string $value = '', ?bool $nullable = true): string|null
    {
        if (strtolower($value) == 'pilih' || !$value) {
            return $nullable ? null : '';
        }

        return $value;
    }
}

if (!function_exists('strip_html')) {
    function strip_html(string|null $string): string
    {
        return $string ? strip_tags(html_entity_decode($string)) : '';
    }
}

if (!function_exists('get_unit_level')) {
    function get_unit_level(string $unit)
    {
        $count = preg_match_all('/\./', $unit, $matches);
        return $count;
    }
}

if (!function_exists('get_unit_manager')) {
    function get_unit_manager(?string $unit = ''): false|string
    {
        if (!$unit) return false;
        return implode('.', array_slice(explode('.', $unit), 0, 3));
    }
}

if (!function_exists('replace_pgs_from_position')) {
    function replace_pgs_from_position(string $position)
    {
        return str_replace('Pgs. ', '', $position);
    }
}


if (!function_exists('replace_id_with_code')) {
    function replace_id_with_code(string $value): string
    {
        return str_replace('_id', '_code', $value);
    }
}

if (!function_exists('excel_build_nested_headers')) {
    function excel_build_nested_headers(array $columns = [], array $nested_columns = []): array
    {
        $headings = [];
        $lowers = [];
        $merged_cells = [];

        foreach ($columns as $index => $heading) {
            $headings[] = $heading;

            // If this heading has nested columns, add them
            if (isset($nested_columns[$heading])) {
                $merged_cells[] = [
                    'start' => count($headings),
                    'count' => count($nested_columns[$heading]),
                    'parent' => $heading
                ];


                $headings = array_merge($headings, array_fill(0, count($nested_columns[$heading]) - 1, ''));
                $lowers = array_merge($lowers, $nested_columns[$heading]);
            } else {
                $merged_cells[] = [
                    'start' => count($headings),
                    'count' => 1,
                    'parent' => false,
                ];
                $lowers[] = '';
            }
        }

        return [[$headings, $lowers], $merged_cells];
    }
}

if (!function_exists('excel_merge_same_values')) {
    /**
     * Merge Excel rows with same values for specified columns
     *
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet The worksheet instance
     * @param array<string> $columns Array of column letters to check for merging
     * @param int $startRow Starting row number (default: 3 for data after headers)
     * @param int $endRow Ending row number
     * @return array Array of merged ranges for reference
     */
    function excel_merge_same_values(
        \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet,
        array $columns,
        int $startRow = 3,
        int $endRow = 3
    ): array {
        $mergedRanges = [];

        foreach ($columns as $column) {
            // Create a map of values to their row numbers
            $valueMap = [];
            for ($row = $startRow; $row <= $endRow; $row++) {
                $value = $sheet->getCell($column . $row)->getValue();
                if (!isset($valueMap[$value])) {
                    $valueMap[$value] = [];
                }
                $valueMap[$value][] = $row;
            }

            // Process each unique value
            foreach ($valueMap as $value => $rows) {
                if (count($rows) > 1) {
                    // Group consecutive rows
                    $groups = [];
                    $currentGroup = [$rows[0]];

                    for ($i = 1; $i < count($rows); $i++) {
                        if ($rows[$i] == $rows[$i - 1] + 1) {
                            // Consecutive row, add to current group
                            $currentGroup[] = $rows[$i];
                        } else {
                            // Non-consecutive row, start new group
                            if (count($currentGroup) > 1) {
                                $groups[] = $currentGroup;
                            }
                            $currentGroup = [$rows[$i]];
                        }
                    }

                    // Add the last group if it has multiple rows
                    if (count($currentGroup) > 1) {
                        $groups[] = $currentGroup;
                    }

                    // Merge each group of consecutive rows
                    foreach ($groups as $group) {
                        $mergeRange = $column . min($group) . ':' . $column . max($group);
                        $sheet->mergeCells($mergeRange);

                        // Center align merged cells vertically
                        $sheet->getStyle($mergeRange)->getAlignment()->setVertical('top');

                        $mergedRanges[] = $mergeRange;
                    }
                }
            }
        }

        return $mergedRanges;
    }
}
