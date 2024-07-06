<?php

namespace App\VO\Chart;

class ChartDataVO
{
    public array $labels;
    public array $datasets;

    /**
     * @param array $labels
     * @param DatasetsVO[]|DatasetsVO $datasets
     */
    public function __construct(array $labels, DatasetsVO|array $datasets)
    {
        $this->labels = $labels;
        $this->datasets = $datasets;
    }
}
