<?php

namespace PyzTest\Service\Fixer;

use Codeception\Stub;
use Generated\Shared\Transfer\PriceExchangeTransfer;
use Pyz\Service\Fixer\FixerService;
use Codeception\Test\Unit;

class FixerServiceTest extends Unit
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

    }

    /**
     * @return void
     */
    public function testGetExchangeRateDataSuccessReturnExchangeRateTransfer()
    {
        $getFixer = Stub::make(FixerService::class, ['getPriceExchanges' => new PriceExchangeTransfer()]);
        $priceExchangeTransfer = $getFixer->getPriceExchanges(['VND', 'EUR']);

        $this->assertInstanceOf(PriceExchangeTransfer::class, $priceExchangeTransfer);
    }

    /**
     * @return void
     */
    public function testGetExchangeRateDataFailReturnExchangeRateTransfer()
    {
        $this->expectException(\TypeError::class);
        $getFixer = Stub::make(FixerService::class, ['getPriceExchanges' => 'string']);
        $getFixer->getPriceExchanges(['VND', 'EUR']);
    }
}
