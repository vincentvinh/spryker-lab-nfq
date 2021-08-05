<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Persistence;

use Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToStoreFacadeBridge;

interface PriceProductEntityManagerInterface
{
    /**
     * @param \Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToStoreFacadeBridge $storeFacade
     * @param array $rates
     *
     * @return mixed
     */
    public function updatePriceData(PriceProductToStoreFacadeBridge $storeFacade, array $rates);
}
