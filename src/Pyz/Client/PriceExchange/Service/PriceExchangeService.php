<?php

declare(strict_types = 1);

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\PriceExchange\Service;

use Generated\Shared\Transfer\PriceExchangeTransfer;
use Pyz\Service\Fixer\FixerService;

/**
 * Class Fixer
 *
 * @package Pyz\Client\PriceExchange\Api\Fixer
 */
class PriceExchangeService implements PriceExchangeServiceInterface
{
    public const STATUS_SUCCESS = 200;

    /**
     * @var \Pyz\Service\Fixer\FixerService
     */
    private $fixerService;

    /**
     * @param \Pyz\Service\Fixer\FixerService $fixerService
     */
    public function __construct(
        FixerService $fixerService
    ) {
        $this->fixerService = $fixerService;
    }

    /**
     * Specification:
     * - Get exchange data from fixer.io.
     *
     * @api
     *
     * symbols is an array of country currency symbols like ['USD','VND']
     *
     * @param array $symbols
     *
     * @return \Generated\Shared\Transfer\PriceExchangeTransfer
     */
    public function getPriceExchanges(array $symbols): PriceExchangeTransfer
    {
        return $this->fixerService->getPriceExchanges($symbols);
    }
}
