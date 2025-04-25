<?php

namespace App\Exports\Risk;

use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class HeatmapPointDrawing
{
    const INHERENT_COLOR = '#e8e8e8';
    const RESIDUAL_COLOR = '#3386de';

    protected Drawing $drawing;

    public function __construct()
    {
        $this->drawing = new Drawing();
    }

    /**
     * @param null|string|int $value
     * @param ?string $label
     * @param ?string $color
     * @param ?string $textColor
     * @param ?string $coordinate
     * @param ?int $offsetX
     * @param ?int $offsetY
     * @return Drawing
     */
    public function make(
        null|string|int $value = 0,
        ?string $label = '',
        ?string $color = self::INHERENT_COLOR,
        ?string $textColor = 'black',
        ?string $coordinate = '',
        ?int $offsetX = 0,
        ?int $offsetY = 0,
    ): Drawing {
        $textColor = $color == self::INHERENT_COLOR ? 'black' : 'white';
        $svg = <<<SVG
        <svg width="64" height="64" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <circle cx="32" cy="32" r="32" fill="{$color}" stroke="black" stroke-width="1" />
            <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="{$textColor}">{$value}</text>
        </svg>
        SVG;

        $filename = Str::uuid()->toString();
        if (!file_exists(storage_path('app/private/heatmap'))) {
            mkdir(storage_path('app/private/heatmap'), 0777, true);
        }
        file_put_contents(storage_path('app/private/heatmap/' . $filename . $value . '.svg'), $svg);

        $label = $label ?: $value;
        $this->drawing->setName($value);
        $this->drawing->setDescription($label);
        $this->drawing->setPath(storage_path('app/private/heatmap/' . $filename . $value . '.svg'));
        $this->drawing->setResizeProportional(false);
        $this->drawing->setHeight(48);
        $this->drawing->setWidth(48);
        $this->drawing->setCoordinates($coordinate);
        $this->drawing->setOffsetX($offsetX);
        $this->drawing->setOffsetY($offsetY);

        return $this->drawing;
    }
}
