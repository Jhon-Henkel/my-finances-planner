<?php

namespace Tests\backend\Unit\VO\Chart;

use App\VO\Chart\DatasetsVO;
use Tests\backend\Falcon9;

class DatasetsVoUnitTest extends Falcon9
{
    public function testConstruct()
    {
        $label = ['label'];
        $backgroundColor = ['backgroundColor'];
        $borderColor = ['borderColor'];
        $data = ['data'];

        $datasetsVo = new DatasetsVO($label, $backgroundColor, $borderColor, $data);

        $this->assertEquals($label, $datasetsVo->label);
        $this->assertEquals($backgroundColor, $datasetsVo->backgroundColor);
        $this->assertEquals($borderColor, $datasetsVo->borderColor);
        $this->assertEquals($data, $datasetsVo->data);
    }

    public function testAddData()
    {
        $label = ['label'];
        $backgroundColor = ['backgroundColor'];
        $borderColor = ['borderColor'];
        $data = ['data'];

        $datasetsVo = new DatasetsVO($label, $backgroundColor, $borderColor, $data);

        $this->assertEquals($label, $datasetsVo->label);
        $this->assertEquals($backgroundColor, $datasetsVo->backgroundColor);
        $this->assertEquals($borderColor, $datasetsVo->borderColor);
        $this->assertEquals($data, $datasetsVo->data);
        $this->assertCount(1, $datasetsVo->data);

        $datasetsVo->addData(10.50);

        $this->assertCount(2, $datasetsVo->data);
    }
}
