<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Client\PriceExchange\Service;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceExchangeTransfer;
use Pyz\Client\PriceExchange\Service\PriceExchangeService;
use Pyz\Service\Fixer\FixerService;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Client
 * @group PriceExchange
 * @group Service
 * @group PriceExchangeServiceTest
 * Add your own group annotations below this line
 */
class PriceExchangeServiceTest extends Unit
{
    /**
     * @var object
     */
    private $priceExchangeService;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $priceExchangeTransfer = new PriceExchangeTransfer();
        $fixerService = $this->make(
            FixerService::class,
            [
                'getPriceExchanges' => $priceExchangeTransfer,
            ]
        );
        $this->priceExchangeService = $this->construct(
            PriceExchangeService::class,
            [
                'fixerService' => $fixerService,
            ]
        );
    }

    /**
     * @return void
     */
    public function testGetExchangeRateDataSuccessReturnExchangeRateTransfer()
    {
        $priceExchangeTransfer = $this->priceExchangeService->getPriceExchanges(['VND', 'EUR']);

        $this->assertInstanceOf(PriceExchangeTransfer::class, $priceExchangeTransfer);
    }
}
