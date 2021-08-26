<?php

namespace Pyz\Zed\ProductBrand\Dependency;

interface ProductBrandEvents
{
    /**
     * Specification:
     * - This events will be used for spy_brand entity creation
     *
     * @api
     */
    public const ENTITY_SPY_PRODUCT_BRAND_CREATE = 'Entity.spy_product_brand.create';

    /**
     * Specification:
     * - This events will be used for spy_brand entity changes
     *
     * @api
     */
    public const ENTITY_SPY_PRODUCT_BRAND_UPDATE = 'Entity.spy_product_brand.update';

    /**
     * Specification:
     * - This events will be used for spy_brand entity deletion
     *
     * @api
     */
    public const ENTITY_SPY_PRODUCT_BRAND_DELETE = 'Entity.spy_product_brand.delete';
}
