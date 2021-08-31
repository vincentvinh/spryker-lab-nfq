<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\BrandSearch\Communication\Plugin\PageDataLoader;

use Generated\Shared\Transfer\BrandSearchTransfer;
use Generated\Shared\Transfer\BrandTransfer;
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
        $payloadTransfers = $this->setBrand($loadTransfer->getPayloadTransfers());
        $loadTransfer->setPayloadTransfers($payloadTransfers);

        return $loadTransfer;
    }

    /**
     * @param int[] $productAbstractIds
     * @param \Generated\Shared\Transfer\ProductPayloadTransfer[] $payloadTransfers
     *
     * @return array
     */
    protected function setBrand(array $payloadTransfers): array
    {
        foreach ($payloadTransfers as $payloadTransfer) {
            $brand = $this->getFactory()->getProductBrandQueryContainer()->queryBrandByProductAbstractId($payloadTransfer->getIdProductAbstract());
            if (isset($brand)) {
                $brandToBeMappedToTransfer = $brand->toArray();
                //find a brand if exist to set if exist
                $brandTransfer = new BrandSearchTransfer();

                $brandTransfer->fromArray($brandToBeMappedToTransfer, true);
                $payloadTransfer->setBrand($brandTransfer);
            }
        }

        return $payloadTransfers;
    }
}
