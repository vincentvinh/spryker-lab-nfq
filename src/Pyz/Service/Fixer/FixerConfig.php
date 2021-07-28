<?php

namespace Pyz\Service\Fixer;

use Generated\Shared\Transfer\PriceExchangeConfigTransfer;
use Pyz\Shared\PriceExchange\PriceExchangeConstants;
use Spryker\Client\Kernel\AbstractBundleConfig;

/**
 * Class FixerConfig
 */
class FixerConfig extends AbstractBundleConfig
{
    public const BASE_URL = 'baseUrl';
    public const API_KEY = 'apiKey';
    public const PRICE_EXCHANGE_METHOD = 'priceExchangeMethod';
    public const PRICE_EXCHANGE_URI = 'priceExchangeUri';

    /**
     * @return PriceExchangeConfigTransfer
     */
    public function getFixerConfig(): PriceExchangeConfigTransfer
    {
        $fixerConfigTransfer = new PriceExchangeConfigTransfer();
        $fixerConfigTransfer->fromArray([
            static::BASE_URL => $this->get(PriceExchangeConstants::FIXER_API_BASE_URL),
            static::API_KEY => $this->get(PriceExchangeConstants::FIXER_API_KEY),
            static::PRICE_EXCHANGE_METHOD => $this->get(PriceExchangeConstants::FIXER_EXCHANGE_RATE_METHOD),
            static::PRICE_EXCHANGE_URI => $this->get(PriceExchangeConstants::FIXER_EXCHANGE_RATE_URI),
        ]);

        return $fixerConfigTransfer;
    }
}
