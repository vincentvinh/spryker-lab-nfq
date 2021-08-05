<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Pyz\Zed\PriceProduct\Persistence\PriceProductQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\PriceProduct\Business\PriceProductFacadeInterface getFacade()
 */
class ExchangeRateCommand extends Console
{
    public const COMMAND_NAME = 'price-product-storage:price:update';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription('This job will be ran every day to update price exchange for different currency');
        $this->addArgument('currency', InputArgument::OPTIONAL, 'The target currencies', 'USD,CHF,VND');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getFacade()->updatePriceProduct(explode(',', $input->getArgument('currency')));

        return 0;
    }
}
