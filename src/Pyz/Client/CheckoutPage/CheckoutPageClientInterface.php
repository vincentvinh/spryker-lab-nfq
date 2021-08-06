<?php

namespace Pyz\Client\CheckoutPage;

/**
 * Provides metadata about an attribute.
 *
 * @api
 */
interface CheckoutPageClientInterface
{
    /**
     * Specification:
     * - Get product on tab More when checkout.
     *
     * @api
     *
     * @param int $limit
     *
     * @return array
     */
    public function getMoreProducts(int $limit): array;
}
