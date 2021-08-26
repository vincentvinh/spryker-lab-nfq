<?php

namespace PyzTest\Zed\Brand\Business;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\BrandBuilder;
use Generated\Shared\DataBuilder\BrandLocalizedAttributeBuilder;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Brand
 * @group Business
 * @group Facade
 * @group BrandFacadeTest
 * Add your own group annotations below this line
 */
class BrandFacadeTest extends Unit
{
    /**
     * @var \PyzTest\Zed\Brand\BrandBusinessTester
     */
    protected $tester;

    /**
     * @return \Generated\Shared\DataBuilder\BrandBuilder|\Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function initBrandTransfer()
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

    /**
     * @return \Generated\Shared\Transfer\BrandTransfer
     */
    public function testBrandSaveCorrectly(): BrandTransfer
    {
        /** @var \Generated\Shared\Transfer\BrandTransfer $brandTransfer */
        $brandTransfer = $this->initBrandTransfer();

        $nameBrand = $brandTransfer->getName();

        $this->tester->getFacade()->create($brandTransfer);

        $this->assertSame($nameBrand, $brandTransfer->getName());

        return $brandTransfer;
    }

    /**
     * @depends testBrandSaveCorrectly
     *
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function testBrandFindCorrectly(BrandTransfer $brandTransfer)
    {
        /**
         * @var \Generated\Shared\Transfer\BrandTransfer $brandResultTransfer
         */
        $brandResultTransfer = $this->tester->getFacade()->getBrandById($brandTransfer->getIdBrand());

        $this->assertEqualsCanonicalizing($brandTransfer->toArray(), $brandResultTransfer->toArray());
    }

    /**
     * @depends testBrandSaveCorrectly
     *
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandTransfer
     */
    public function testBrandEditCorrectly(BrandTransfer $brandTransfer): BrandTransfer
    {
        $nameBrandEdit = $brandTransfer->getName() . '1';
        $brandTransfer->setName($nameBrandEdit);
        /**
         * @var \Generated\Shared\Transfer\BrandTransfer $brandResultTransfer
         */
        $this->tester->getFacade()->update($brandTransfer);
        $this->assertSame($nameBrandEdit, $brandTransfer->getName());

        return $brandTransfer;
    }

    /**
     * @depends testBrandSaveCorrectly
     *
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandTransfer
     */
    public function testBrandEditSameNameCorrectly(BrandTransfer $brandTransfer): BrandTransfer
    {
        $nameOrigin = $brandTransfer->getName();
        /**
         * @var \Generated\Shared\Transfer\BrandTransfer $brandResultTransfer
         */
        $this->tester->getFacade()->update($brandTransfer);
        $this->assertSame($nameOrigin, $brandTransfer->getName());

        return $brandTransfer;
    }

    /**
     * @depends testBrandEditCorrectly
     *
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function testBrandDeleteCorrectly(BrandTransfer $brandTransfer)
    {
        $brandResultTransfer = $this->tester->getFacade()->delete($brandTransfer);

        $this->assertEmpty($brandResultTransfer);
    }
}
