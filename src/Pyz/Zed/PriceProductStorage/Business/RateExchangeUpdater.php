<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductStorage\Business;

use Generated\Shared\Transfer\StoreTransfer;
use Pyz\Client\PriceExchange\PriceExchangeClient;
use Pyz\Zed\PriceProductStorage\Persistence\PriceProductStorageEntityManager;
use Pyz\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainerInterface;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * Class RateExchangeUpdater
 *
 * @package Pyz\Zed\PriceProductStorage\Business
 */
class RateExchangeUpdater implements RateExchangeUpdaterInterface
{
    /**
     * @var array $rates
     */
    protected $rates;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer $currentStore
     */
    protected $currentStore;

    /**
     * @var \Spryker\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface $queryContainer
     */
    protected $queryContainer;

    /**
     * @var PriceProductStorageEntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $store
     * @param \Pyz\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Kernel\Persistence\AbstractEntityManager $entityManager
     */
    public function __construct(
        StoreTransfer $store,
        PriceProductStorageQueryContainerInterface $queryContainer,
        AbstractEntityManager $entityManager
    ) {
        $this->currentStore = $store;
        $this->queryContainer = $queryContainer;
        $this->entityManager = $entityManager;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->getRates();
        $this->updateProductPrice();
    }

    /**
     * get exchange rate
     *
     * @return void
     */
    public function getRates()
    {
        $client = new PriceExchangeClient();
        $currentCurrency = $this->currentStore->getSelectedCurrencyIsoCode();

        $exchangeTransfer = $client->getExchangeData($this->currentStore->getAvailableCurrencyIsoCodes());
        $this->rates = $exchangeTransfer->getRates();

        echo "[+] Rates (compare with $currentCurrency):";
        foreach ($this->rates as $symbol => $rate) {
            if ($symbol == $currentCurrency) {
                unset($this->rates[$symbol]);
                continue;
            }
            echo "\n - $symbol: $rate";
        }
    }

    /**
     * Perform update
     *
     * @return void
     */
    public function updateProductPrice()
    {
        $this->entityManager->updatePriceData($this->rates, $this->queryContainer, $this->currentStore->getName());
    }
}
