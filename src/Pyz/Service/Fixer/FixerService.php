<?php

namespace Pyz\Service\Fixer;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use Spryker\Service\Kernel\AbstractService;

/**
 * @method FixerServiceFactory getFactory()
 */
class FixerService extends AbstractService implements FixerServiceInterface
{
    /**
     * @param array $symbols
     *
     * @return PriceExchangeTransfer
     */
    public function getPriceExchanges(array $symbols): PriceExchangeTransfer
    {
        return $this->getFactory()->createFixerService()->getPriceExchangeData($symbols);
    }
}
