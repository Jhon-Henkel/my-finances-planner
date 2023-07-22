<?php

namespace Tests\Unit\Factory;

use App\DTO\InvoiceItemDTO;
use App\Factory\InvoiceFactory;
use Tests\Falcon9;

class InvoiceFactoryUnitTest extends Falcon9
{
    public function testFactoryInvoiceWithSixInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-1', 5);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(502.50, $testOne->totalRemainingValue);
        $this->assertEquals(100.5, $testOne->firstInstallment);
        $this->assertEquals(100.5, $testOne->secondInstallment);
        $this->assertEquals(100.5, $testOne->thirdInstallment);
        $this->assertEquals(100.5, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(null, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithOnlyFirstInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-1', 1);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(100.5, $testOne->totalRemainingValue);
        $this->assertEquals(100.5, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(null, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithOnlySecondInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-2', 1);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(100.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(100.5, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(null, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithOnlyThirdInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-3', 1);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(100.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(100.5, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(null, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithOnlyForthInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-4', 1);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(100.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(100.5, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(null, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithOnlyFifthInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-5', 1);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(100.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(null, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithOnlySixthInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-6', 1);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(100.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithOnlyFirstInstallmentsNull()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-2', 5);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(502.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(100.5, $testOne->secondInstallment);
        $this->assertEquals(100.5, $testOne->thirdInstallment);
        $this->assertEquals(100.5, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithFromSecondInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-3', 4);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(402, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(100.5, $testOne->thirdInstallment);
        $this->assertEquals(100.5, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithFromThirdInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-4', 3);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(301.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(100.5, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithFromForthInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-5', 2);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(201, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithFromFifthInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-6', 1);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(100.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithAllNull()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-6', 1);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(100.5, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithAllNullAndRemainingSixInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-6', 6);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(603, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithFixInstallments()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2023-6', 0);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 1);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(0, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithNewYearsEveOnSecondInstallment()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2024-1', 6);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 12);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(603, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(100.5, $testOne->secondInstallment);
        $this->assertEquals(100.5, $testOne->thirdInstallment);
        $this->assertEquals(100.5, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithNewYearsEveOnThirdInstallment()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2024-1', 6);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 11);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(603, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(100.5, $testOne->thirdInstallment);
        $this->assertEquals(100.5, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithNewYearsEveOnFourthInstallment()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2024-1', 6);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 10);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(603, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(100.5, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithNewYearsEveOnFifthInstallment()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2024-2', 6);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 10);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(603, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(100.5, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }

    public function testFactoryInvoiceWithNewYearsEveOnSixthInstallment()
    {
        $dtoOne = new InvoiceItemDTO(1, 50, 'Test-one', 'Test-one', 100.5, '2024-3', 6);
        $testOne = InvoiceFactory::factoryInvoice($dtoOne, 10);

        $this->assertEquals(1, $testOne->id);
        $this->assertEquals(50, $testOne->countId);
        $this->assertEquals('Test-one', $testOne->name);
        $this->assertEquals('Test-one', $testOne->countName);
        $this->assertEquals(603, $testOne->totalRemainingValue);
        $this->assertEquals(null, $testOne->firstInstallment);
        $this->assertEquals(null, $testOne->secondInstallment);
        $this->assertEquals(null, $testOne->thirdInstallment);
        $this->assertEquals(null, $testOne->forthInstallment);
        $this->assertEquals(null, $testOne->fifthInstallment);
        $this->assertEquals(100.5, $testOne->sixthInstallment);
    }
}