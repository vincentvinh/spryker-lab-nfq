<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Brand\Communication\Form\DataProvider;

use Generated\Shared\Transfer\BrandLocalizedAttributesTransfer;
use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;

class BrandEditDataProvider
{
    /**
     * @var \Pyz\Zed\Brand\Business\BrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @var \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \Pyz\Zed\Brand\Business\BrandFacadeInterface $brandFacade
     * @param \Spryker\Zed\Locale\Business\LocaleFacadeInterface $localeFacade
     */
    public function __construct(
        BrandFacadeInterface $brandFacade,
        LocaleFacadeInterface $localeFacade
    ) {
        $this->brandFacade = $brandFacade;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param int $brandId
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    public function getData(int $brandId): ?BrandTransfer
    {
        return $this->buildBrandTransfer($brandId);
    }

    /**
     * @param int $brandId
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    protected function buildBrandTransfer(int $brandId): ?BrandTransfer
    {
        $brandTransfer = $this->brandFacade->getBrandById($brandId);

        if ($brandTransfer !== null) {
            $brandTransfer = $this->addLocalizedAttributeTransfers($brandTransfer);
        }

        return $brandTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandTransfer
     */
    protected function addLocalizedAttributeTransfers(BrandTransfer $brandTransfer): BrandTransfer
    {
        $brandLocaleIds = $this->getBrandLocaleIds($brandTransfer);

        foreach ($this->localeFacade->getLocaleCollection() as $localeTransfer) {
            if (in_array($localeTransfer->getIdLocale(), $brandLocaleIds)) {
                continue;
            }

            $categoryLocalizedAttributesTransfer = $this->createEmptyBrandLocalizedAttributesTransfer($localeTransfer);
            $brandTransfer->addLocalizedAttributes($categoryLocalizedAttributesTransfer);
        }

        return $brandTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return int[]
     */
    protected function getBrandLocaleIds(BrandTransfer $brandTransfer): array
    {
        $categoryLocaleIds = [];

        foreach ($brandTransfer->getLocalizedAttributes() as $localizedAttribute) {
            $categoryLocaleIds[] = $localizedAttribute->getLocale()->getIdLocale();
        }

        return $categoryLocaleIds;
    }

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\BrandLocalizedAttributeTransfer
     */
    protected function createEmptyBrandLocalizedAttributesTransfer(LocaleTransfer $localeTransfer): BrandLocalizedAttributeTransfer
    {
        return (new BrandLocalizedAttributeTransfer())->setLocale($localeTransfer);
    }
}
