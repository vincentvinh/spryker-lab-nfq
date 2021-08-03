<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Client\PriceExchange;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceExchangeTransfer;
use Pyz\Client\PriceExchange\PriceExchangeClient;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Client
 * @group PriceExchange
 * @group PriceExchangeClientTest
 * Add your own group annotations below this line
 */
class PriceExchangeClientTest extends Unit
{
    /**
     * @var object
     */
    private $priceExchangeClient;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $priceExchangeTransfer = new PriceExchangeTransfer();
        $this->priceExchangeClient = $this->make(
            PriceExchangeClient::class,
            [
                'getExchangeData' => $priceExchangeTransfer,
            ]
        );
    }

    /**
     * @return void
     */
    public function testGetExchangeRateDataSuccessReturnExchangeRateTransfer()
    {
        $priceExchangeTransfer = $this->priceExchangeClient->getExchangeData(['VND', 'EUR']);

        $this->assertInstanceOf(PriceExchangeTransfer::class, $priceExchangeTransfer);
    }
}
