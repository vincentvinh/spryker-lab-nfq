<?php

namespace Pyz\Client\PriceExchange;

use Generated\Shared\Transfer\PriceExchangeTransfer;

interface PriceExchangeClientInterface
{
    /**
     * @param array $symbols
     *
     * @return PriceExchangeTransfer
     */
    public function getExchangeData(array $symbols): PriceExchangeTransfer;
}
