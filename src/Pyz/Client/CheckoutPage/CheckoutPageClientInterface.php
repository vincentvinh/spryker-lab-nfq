<?php

namespace Pyz\Client\CheckoutPage;

interface CheckoutPageClientInterface
{
    /**
     * @param int $limit
     *
     * @return array
     */
    public function getMoreProducts(int $limit): array;
}
