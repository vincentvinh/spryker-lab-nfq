<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Brand\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\BrandBuilder;
use Generated\Shared\DataBuilder\BrandLocalizedAttributeBuilder;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class BrandDataHelper extends Module
{
    use LocatorHelperTrait;

    /**
     * @return \Generated\Shared\Transfer\BrandTransfer
     */
    public function haveBrand(): BrandTransfer
    {
        $brandTransfer = $this->generateBrandTransfer();

        $this->getBrandFacade()->create($brandTransfer);

        return $brandTransfer;
    }

    /**
     * @return \Pyz\Zed\Brand\Business\BrandFacadeInterface
     */
    protected function getBrandFacade(): BrandFacadeInterface
    {
        return $this->getLocator()->brand()->facade();
    }

    /**
     * @return \Generated\Shared\Transfer\BrandTransfer|\Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function generateBrandTransfer()
    {
        $brandBuilder = (new BrandBuilder([
            'description' => 'brand-description',
            'isSearchable' => true,
            'isHighlight' => true,
            'logo' => 'https://i.pinimg.com/originals/4a/5c/7d/4a5c7dc0c88598093e5449b392a1b4b5.png',
        ]))->build();

        $locales = new LocaleTransfer();
        $locales->setIdLocale(66)->setIsActive(true)->setLocaleName('en_US');
        $localized_attributes = (new BrandLocalizedAttributeBuilder(['metaDescription' => 'metaDescription']))->build();
        $localized_attributes->setLocale($locales);
        $brandBuilder->addLocalizedAttributes($localized_attributes);

        return $brandBuilder;
    }
}
