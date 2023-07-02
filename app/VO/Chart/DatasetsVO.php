<?php

namespace App\VO\Chart;

class DatasetsVO
{
    public array|string $label;
    public array|string $backgroundColor;
    public array|string $borderColor;
    public array $data;

    /**
     * @param string[]|string $label
     * @param string[]|string $backgroundColor
     * @param string[]|string $borderColor
     * @param array $data
     */
    public function __construct(
        array|string $label,
        array|string $backgroundColor = [],
        array|string $borderColor = [],
        array $data = []
    ) {
        $this->label = $label;
        $this->backgroundColor = $backgroundColor;
        $this->borderColor = $borderColor;
        $this->data = $data;
    }

    public function addData(int|float $data): void
    {
        $this->data[] = $data;
    }
}