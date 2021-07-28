<?php

namespace Pyz\Client\PriceExchange;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
* @method PriceExchangeFactory getFactory()
*/
class PriceExchangeClient extends AbstractClient implements PriceExchangeClientInterface
{
    /**
     * @param array $symbols
     *
     * @return PriceExchangeTransfer
     */
    public function getExchangeData(array $symbols): PriceExchangeTransfer
    {
        return $this->getFactory()->createPriceExchange()->getPriceExchanges($symbols);
    }
}
