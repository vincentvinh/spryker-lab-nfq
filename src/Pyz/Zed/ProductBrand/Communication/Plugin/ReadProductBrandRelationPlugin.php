<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Communication\Plugin;

use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Brand\Dependency\Plugin\BrandRelationReadPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\ProductBrand\Business\ProductBrandFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductBrand\Communication\ProductBrandCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductBrand\ProductBrandConfig getConfig()
 * @method \Spryker\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface getQueryContainer()
 */
class ReadProductBrandRelationPlugin extends AbstractPlugin implements BrandRelationReadPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getRelationName()
    {
        return 'Products';
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return string[]
     */
    public function getRelations(BrandTransfer $brandTransfer, LocaleTransfer $localeTransfer)
    {
        $productNames = [];
        $productTransferCollection = $this
            ->getFacade()
            ->getAbstractProductsByIdBrand($brandTransfer->getIdBrand(), $localeTransfer);

        foreach ($productTransferCollection as $productTransfer) {
            $productNames[] = sprintf(
                '%s (%s)',
                $productTransfer->getLocalizedAttributes()[0]->getName(),
                $productTransfer->getSku()
            );
        }

        return $productNames;
    }
}
