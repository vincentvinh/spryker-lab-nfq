<?php

namespace Pyz\Zed\PriceProductStorage\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExchangeRateCommand extends Console
{
    const COMMAND_NAME = 'price-product-storage:price:update';

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
        $this->getFacade()->updatePriceProductConcreteStorage();
    }

}
