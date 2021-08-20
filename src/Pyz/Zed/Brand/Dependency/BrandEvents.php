<?php

namespace Pyz\Zed\Brand\Dependency;

interface BrandEvents
{
    /**
     * Specification:
     * - This events will be used for spy_brand entity creation
     *
     * @api
     */
    public const ENTITY_SPY_BRAND_CREATE = 'Entity.spy_brand.create';

    /**
     * Specification:
     * - This events will be used for spy_brand entity changes
     *
     * @api
     */
    public const ENTITY_SPY_BRAND_UPDATE = 'Entity.spy_brand.update';

    /**
     * Specification:
     * - This events will be used for spy_brand entity deletion
     *
     * @api
     */
    public const ENTITY_SPY_BRAND_DELETE = 'Entity.spy_brand.delete';

    /**
     * Specification:
     * - This events will be used for Brand publish
     *
     * @api
     */
    public const BRAND_PUBLISH = 'Brand.publish';

    /**
     * Specification:
     * - This events will be used for Brand publish
     *
     * @api
     */
    public const BRAND_UNPUBLISH = 'Brand.unpublish';
}
