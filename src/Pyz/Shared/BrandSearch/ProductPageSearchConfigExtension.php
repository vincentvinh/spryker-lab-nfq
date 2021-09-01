<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Shared\BrandSearch;

use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;

class ProductPageSearchConfigExtension extends ProductPageSearchConfig
{
    /**
     * Specification:
     * - This constant is used for extracting data from plugin array
     *
     * @api
     */
    public const PLUGIN_PRODUCT_BRAND_PAGE_DATA = 'PLUGIN_PRODUCT_BRAND_PAGE_DATA';
}
