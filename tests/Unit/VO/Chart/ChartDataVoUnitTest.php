<?php

namespace Tests\Unit\VO\Chart;

use App\VO\Chart\ChartDataVO;
use App\VO\Chart\DatasetsVO;
use Tests\TestCase;

class ChartDataVoUnitTest extends TestCase
{
    public function testConstruct()
    {
        $labels = ['label1', 'label2'];
        $datasets = [
            new DatasetsVO(
                'label',
                'backgroundColor',
                'borderColor',
                [1, 2]
            )
        ];
        $vo = new ChartDataVO($labels, $datasets);
        $this->assertEquals($labels, $vo->labels);
        $this->assertEquals($datasets, $vo->datasets);
    }
}