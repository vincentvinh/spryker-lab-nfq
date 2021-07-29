<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\Fixer;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use Spryker\Service\Kernel\AbstractService;

/**
 * @method \Pyz\Service\Fixer\FixerServiceFactory getFactory()
 */
class FixerService extends AbstractService implements FixerServiceInterface
{
    /**
     * @param array $symbols
     *
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    public function getPriceExchanges(array $symbols): PriceExchangeTransfer
    {
        return $this->getFactory()->createFixerService()->getPriceExchangeData($symbols);
    }
}
