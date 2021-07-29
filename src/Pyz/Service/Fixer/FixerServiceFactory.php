<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\Fixer;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use GuzzleHttp\ClientInterface;
use Pyz\Service\Fixer\Api\GetFixer;
use Pyz\Service\Fixer\Api\GetFixerInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;

/**
 * @method \Pyz\Service\Fixer\FixerConfig getConfig()
 */
class FixerServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \Pyz\Service\Fixer\Api\GetFixerInterface
     */
    public function createFixerService(): GetFixerInterface
    {
        return new GetFixer(
            $this->getHttpClient(),
            $this->getConfig(),
            $this->createPriceExchangeTransfer()
        );
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->getProvidedDependency(FixerDependencyProvider::HTTP_CLIENT);
    }

    /**
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    private function createPriceExchangeTransfer(): PriceExchangeTransfer
    {
        return new PriceExchangeTransfer();
    }
}
