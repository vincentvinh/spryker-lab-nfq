<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\BrandSearch\Communication\Plugin\PageDataLoader;

use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Pyz\Zed\BrandSearch\Communication\BrandSearchCommunicationFactory;
use Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductPageDataLoaderPluginInterface;

/**
 * @method BrandSearchCommunicationFactory getFactory()
 * @method BrandSearchQueryContainer getQueryContainer()
 * @method \Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductPageSearch\ProductPageSearchConfig getConfig()
 */
class BrandPageDataLoaderPlugin extends AbstractPlugin implements ProductPageDataLoaderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductPageLoadTransfer $loadTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    public function expandProductPageDataTransfer(ProductPageLoadTransfer $loadTransfer)
    {
        $payloadTransfers = $this->setProductBrand($loadTransfer->getProductAbstractIds(), $loadTransfer->getPayloadTransfers());
        $loadTransfer->setPayloadTransfers($payloadTransfers);

        return $loadTransfer;
    }

    /**
     * @param int[] $productAbstractIds
     * @param \Generated\Shared\Transfer\ProductPayloadTransfer[] $payloadTransfers
     *
     * @return array
     */
    protected function setProductBrand(array $productAbstractIds, array $payloadTransfers): array
    {
        $query = $this->getFactory()->getProductBrandQueryContainer()->queryProductBrandByProductAbstractIds($productAbstractIds);

        $productBrandEntities = $query->find();
        $formattedProductBrand = [];
        foreach ($productBrandEntities as $productBrandEntity) {
            $formattedProductBrand[$productBrandEntity->getFkProductAbstract()][] = $productBrandEntity->getFkBrand();
        }

        foreach ($payloadTransfers as $payloadTransfer) {
            if (!isset($formattedProductBrand[$payloadTransfer->getIdProductAbstract()])) {
                continue;
            }

            $idBrand = $formattedProductBrand[$payloadTransfer->getIdProductAbstract()];
            $payloadTransfer->setIdBrand($idBrand);
        }

        return $payloadTransfers;
    }
}
