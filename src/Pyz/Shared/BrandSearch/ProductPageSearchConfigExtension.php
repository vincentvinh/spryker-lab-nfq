<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
    public const PLUGIN_PRODUCT_BRAND_PAGE_DATA = 'PLUGIN_PRODUCT_CATEGORY_PAGE_DATA';
}
