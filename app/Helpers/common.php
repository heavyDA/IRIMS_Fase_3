<?php

use App\Enums\State;
use Carbon\Carbon;

if (!function_exists('format_date')) {
    function format_date(string $date): Carbon
    {
        return Carbon::parse($date);
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
