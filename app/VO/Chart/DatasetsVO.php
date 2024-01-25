<?php

namespace App\VO\Chart;

class DatasetsVO
{
    public array|string $label;
    public array|string $backgroundColor;
    public array|string $borderColor;
    public array $data;

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

    public function addData(null|float $data): void
    {
        $this->data[] = $data;
    }
}