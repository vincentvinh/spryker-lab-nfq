<?php

namespace Pyz\Zed\PriceProductStorage\Business;


use Pyz\Zed\PriceProductStorage\PriceProductStorageDependencyProvider;

class PriceProductStorageBusinessFactory extends \Spryker\Zed\PriceProductStorage\Business\PriceProductStorageBusinessFactory
{
    /**
     * @return \Spryker\Zed\AvailabilityGui\Dependency\Facade\AvailabilityToStoreFacadeInterface
     */
    public function getStoreFacade()
    {
        return $this->getProvidedDependency(PriceProductStorageDependencyProvider::FACADE_STORE);
    }

    public function getRateExchangeUpdater(){
        return new RateExchangeUpdater(
            $this->getStoreFacade()->getCurrentStore(),
            $this->getQueryContainer()
        );
    }
}

