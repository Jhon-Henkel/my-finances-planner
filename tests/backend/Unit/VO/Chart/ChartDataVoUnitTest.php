<?php

namespace Tests\backend\Unit\VO\Chart;

use App\VO\Chart\ChartDataVO;
use App\VO\Chart\DatasetsVO;
use Tests\backend\Falcon9;

class ChartDataVoUnitTest extends Falcon9
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
