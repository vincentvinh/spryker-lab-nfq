<?php

namespace Pyz\Zed\PriceProductStorage\Business;

use Generated\Shared\Transfer\StoreTransfer;
use Pyz\Client\PriceExchange\PriceExchangeClient;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use Spryker\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface;

class RateExchangeUpdater implements RateExchangeUpdaterInterface
{
    /** @var array $rates */
    protected $rates;

    /** @var \Generated\Shared\Transfer\StoreTransfer $currentStore */
    protected $currentStore;

    /** @var PriceProductQueryContainerInterface $queryContainer */
    protected $queryContainer;

    /** @var AbstractEntityManager $entityManager */
    protected $entityManager;

    public function __construct(
        StoreTransfer $store,
        \Pyz\Zed\PriceProductStorage\Persistence\PriceProductStorageQueryContainerInterface $queryContainer,
        AbstractEntityManager $entityManager
    )
    {
        $this->currentStore = $store;
        $this->queryContainer = $queryContainer;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function execute()
    {
        $this->getRates();
        $this->updateProductPrice();
    }

    /**
     * get exchange rate
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
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function updateProductPrice()
    {
        $this->entityManager->updatePriceData($this->rates, $this->queryContainer, $this->currentStore->getName());
    }
}
