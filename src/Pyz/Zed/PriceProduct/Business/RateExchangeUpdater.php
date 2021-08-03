<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Business;

use Generated\Shared\Transfer\StoreTransfer;
use Pyz\Client\PriceExchange\PriceExchangeClient;
use Pyz\Zed\PriceProduct\Persistence\PriceProductEntityManager;
use Pyz\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface;

/**
 * Class RateExchangeUpdater
 *
 * @package Pyz\Zed\PriceProduct\Business
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
     * @var \Pyz\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface $queryContainer
     */
    protected $queryContainer;

    /**
     * @var \Pyz\Zed\PriceProduct\Persistence\PriceProductEntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $store
     * @param \Pyz\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface $queryContainer
     * @param \Pyz\Zed\PriceProduct\Persistence\PriceProductEntityManager $entityManager
     */
    public function __construct(
        StoreTransfer $store,
        PriceProductQueryContainerInterface $queryContainer,
        PriceProductEntityManager $entityManager
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
        $this->entityManager->updatePriceData(
            $this->currentStore->getDefaultCurrencyIsoCode(),
            $this->rates,
            $this->currentStore->getIdStore()
        );

        $this->entityManager->publishEvents(
            $this->queryContainer,
            $this->currentStore->getIdStore(),
            $this->rates
        );
    }
}
