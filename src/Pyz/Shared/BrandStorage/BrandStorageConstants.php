<?php

namespace Pyz\Shared\BrandStorage;

interface BrandStorageConstants
{
    /**
     * Specification:
     * - Queue name as used for processing category messages
     *
     * @api
     */
    public const BRAND_SYNC_QUEUE = 'sync.storage.brand';

    /**
     * Specification:
     * - Queue name as used for error category messages
     *
     * @api
     */
    public const BRAND_SYNC_ERROR_QUEUE = 'sync.storage.brand.error';

    /**
     * Specification:
     * - Resource name, this will use for key generating
     *
     * @api
     */
    public const BRAND_RESOURCE_NAME = 'brand';
}
