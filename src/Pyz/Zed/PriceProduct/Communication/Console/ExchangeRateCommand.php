<?php
namespace Pyz\Zed\PriceProduct\Communication\Console;

use Pyz\Client\PriceExchange\PriceExchangeClient;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExchangeRateCommand extends Console
{
    const COMMAND_NAME = 'price-product:price:update';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription('This job will be ran every day to update price exchange for different currency');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new PriceExchangeClient();
        $exchangeTransfer = $client->getExchangeData(['VND']); //TODO just hard-code now for symbols

        var_dump($result->getRates());
    }

}
