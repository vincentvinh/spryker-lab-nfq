<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\BrandSearch\Communication\Plugin\PageMapPlugin;

use Generated\Shared\Transfer\BrandSearchTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

/**
 * @method \Spryker\Zed\ProductListSearch\Business\ProductListSearchFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductListSearch\Communication\ProductListSearchCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductListSearch\ProductListSearchConfig getConfig()
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainerInterface getQueryContainer()
 */
class BrandListMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    protected const KEY_BRAND = 'brand';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ): PageMapTransfer {
        if (!isset($productData[static::KEY_BRAND])) {
            return $pageMapTransfer;
        }
        $brandSearchTransfer = $this->getBrandSearchData($productData);
        $pageMapTransfer->setBrand($brandSearchTransfer);

        return $pageMapTransfer;
    }

    /**
     * @param array $productData
     *
     * @return \Generated\Shared\Transfer\BrandSearchTransfer
     */
    protected function getBrandSearchData(array $productData): BrandSearchTransfer
    {
        $brandSearchMapTransfer = new BrandSearchTransfer();
        $brandSearchMapTransfer->fromArray($productData[static::KEY_BRAND]);

        return $brandSearchMapTransfer;
    }
}
