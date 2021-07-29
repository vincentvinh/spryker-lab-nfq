<?php

namespace Pyz\Zed\PriceProductStorage\Business;

use Pyz\Zed\PriceProductStorage\PriceProductStorageDependencyProvider;

class PriceProductStorageFacade extends \Spryker\Zed\PriceProduct\Business\PriceProductFacade
{
    public function updatePriceProductConcreteStorage()
    {
        $handler = $this->getFactory()->getRateExchangeUpdater();
        $handler->execute();
    }

    /**
     * @return \Spryker\Zed\AvailabilityGui\Dependency\Facade\AvailabilityToStoreFacadeInterface
     */
    public function getStoreFacade()
    {
        return $this->getProvidedDependency(PriceProductStorageDependencyProvider::FACADE_STORE);
    }
}
