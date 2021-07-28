<?php

namespace Pyz\Zed\PriceProductStorage\Business;

class PriceProductStorageFacade extends  \Spryker\Zed\PriceProduct\Business\PriceProductFacade{
    public function updatePriceProductConcreteStorage(){
        $handler = new RateExchange();
        $handler->execute();
    }
}
