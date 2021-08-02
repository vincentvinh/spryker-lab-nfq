<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Service\Fixer;

use Codeception\Stub;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceExchangeTransfer;
use Pyz\Service\Fixer\FixerService;
use TypeError;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Service
 * @group Fixer
 * @group FixerServiceTest
 * Add your own group annotations below this line
 */
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
        $this->expectException(TypeError::class);
        $getFixer = Stub::make(FixerService::class, ['getPriceExchanges' => 'string']);
        $getFixer->getPriceExchanges(['VND', 'EUR']);
    }
}
