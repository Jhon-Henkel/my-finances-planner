<?php

namespace Tests\backend\Unit\Factory\DataGraph\Investment;

use App\Factory\DataGraph\Investment\DataGraphInvestmentFactory;
use Tests\backend\Falcon9;

class DataGraphInvestmentFactoryUnitTest extends Falcon9
{
    public function testAddLabel(): void
    {
        $dataGraphInvestmentFactory = new DataGraphInvestmentFactory();
        $dataGraphInvestmentFactory->addLabel('Test Label');
        $this->assertEquals('Test Label', $dataGraphInvestmentFactory->getAllDataArray()['label']);
    }

    public function testAddValue(): void
    {
        $dataGraphInvestmentFactory = new DataGraphInvestmentFactory();
        $dataGraphInvestmentFactory->addValue(100);
        $this->assertEquals(100, $dataGraphInvestmentFactory->getAllDataArray()['value']);
    }

    public function testGetAllDataArray(): void
    {
        $dataGraphInvestmentFactory = new DataGraphInvestmentFactory();
        $dataGraphInvestmentFactory->addLabel('Test Label');
        $dataGraphInvestmentFactory->addValue(100);
        $this->assertEquals([
            'label' => 'Test Label',
            'value' => 100,
        ], $dataGraphInvestmentFactory->getAllDataArray());
    }
}
