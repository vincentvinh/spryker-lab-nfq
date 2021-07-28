<?php

namespace Pyz\Service\Fixer;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use GuzzleHttp\ClientInterface;
use Pyz\Service\Fixer\Api\GetFixer;
use Pyz\Service\Fixer\Api\GetFixerInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;

/**
 * @method FixerConfig getConfig()
 */
class FixerServiceFactory extends AbstractServiceFactory
{
    /**
     * @return GetFixerInterface
     */
    public function createFixerService(): GetFixerInterface
    {
        return new GetFixer(
            $this->getHttpClient(),
            $this->getConfig(),
            new PriceExchangeTransfer
        );
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->getProvidedDependency(FixerDependencyProvider::HTTP_CLIENT);
    }
}
