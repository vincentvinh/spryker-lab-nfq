<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\BrandSearch\Communication\Plugin\PageDataLoader;

use Generated\Shared\Transfer\BrandSearchLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandSearchTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use Generated\Shared\Transfer\UrlTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductPageDataLoaderPluginInterface;

/**
 * @method \Pyz\Zed\BrandSearch\Communication\BrandSearchCommunicationFactory getFactory()
 * @method \Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainer getQueryContainer()
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
     * @param \Generated\Shared\Transfer\ProductPayloadTransfer[] $payloadTransfers
     *
     * @return array
     */
    protected function setBrand(array $payloadTransfers): array
    {
        foreach ($payloadTransfers as $payloadTransfer) {
            $brand = $this->getFactory()->getProductBrandQueryContainer()->queryBrandByProductAbstractId($payloadTransfer->getIdProductAbstract())->find();
            if (isset($brand)) {
                $brandToBeMappedToTransfer = $brand->getData()[0];
                //find a brand if exist to set if exist
                $brandTransfer = new BrandSearchTransfer();
                $brandEntity = $brandToBeMappedToTransfer->getSpyBrand();

                $brandAttributeEntities = $brandEntity->getAttributes();
                foreach ($brandAttributeEntities as $brandAttributeEntity) {
                    $brandAttributeEntityFormatted = $brandAttributeEntity->toArray();
                    $brandLocaleTransfer = new BrandSearchLocalizedAttributeTransfer();
                    $brandLocaleTransfer->fromArray($brandAttributeEntityFormatted, true);
                    $localeTransfer = new LocaleTransfer();
                    $localeFormatted = $brandAttributeEntity->getLocale()->toArray();
                    $localeTransfer->fromArray($localeFormatted);
                    $brandLocaleTransfer->setLocale($localeTransfer);

                    $urls = $brandEntity->getSpyUrlsJoinSpyLocale();
                    foreach ($urls as $urlEntity) {
                        if ($urlEntity->getFkLocale() == $localeTransfer->getIdLocale()) {
                            $urlEntity = $urlEntity->toArray();
                            $urlTransfer = new UrlTransfer();
                            $urlTransfer->fromArray($urlEntity, true);
                            $brandLocaleTransfer->setUrl($urlTransfer);
                        }
                    }
                    $brandTransfer->addLocalizedAttributes($brandLocaleTransfer);
                }
                $brandTransfer->setName($brandEntity->getName());
                $brandTransfer->setDescription($brandEntity->getDescription());
                $brandTransfer->setIsHighlight($brandEntity->getIsHighlight());
                $brandTransfer->setIsSearchable($brandEntity->getIsSearchable());
                $brandTransfer->setLogo($brandEntity->getLogo());

                $payloadTransfer->setBrand($brandTransfer);
            }
        }

        return $payloadTransfers;
    }
}
