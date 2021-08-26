<?php

namespace PyzTest\Zed\Brand\Business;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\BrandBuilder;
use Generated\Shared\DataBuilder\BrandLocalizedAttributeBuilder;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

/**
* @group PyzTest
* @group Zed
* @group StringReverser
* @group Business
* @group Facade
* @group StringReverserFacadeTest
* Add your own group annotations below this line
*/
class BrandFacadeTest extends Unit
{
    /**
    * @var \PyzTest\Zed\Brand\BrandBusinessTester
    */
    protected $tester;

    /**
     * @return BrandBuilder|\Spryker\Shared\Kernel\Transfer\AbstractTransfer
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
     * @param BrandTransfer $brandTransfer
     */
    public function testBrandSaveCorrectly(): BrandTransfer
    {
        /** @var BrandTransfer $brandTransfer */
        $brandTransfer = $this->initBrandTransfer();

        $nameBrand = $brandTransfer->getName();

        $this->tester->getFacade()->create($brandTransfer);

        $this->assertSame($nameBrand, $brandTransfer->getName());

        return $brandTransfer;
    }

    /**
     * @param BrandTransfer $brandTransfer
     *
     * @depends testBrandSaveCorrectly
     */
    public function testBrandFindCorrectly(BrandTransfer $brandTransfer)
    {
        /**
         * @var BrandTransfer $brandResultTransfer
         */
        $brandResultTransfer = $this->tester->getFacade()->getBrandById($brandTransfer->getIdBrand());

        $this->assertEqualsCanonicalizing($brandTransfer->toArray(), $brandResultTransfer->toArray());
    }

    /**
     * @param BrandTransfer $brandTransfer
     *
     * @depends testBrandSaveCorrectly
     *
     * @return BrandTransfer
     */
    public function testBrandEditCorrectly(BrandTransfer $brandTransfer)
    {
        $nameBrandEdit = $brandTransfer->getName() . '1';
        $brandTransfer->setName($nameBrandEdit);
        /**
         * @var BrandTransfer $brandResultTransfer
         */
        $this->tester->getFacade()->update($brandTransfer);
        $this->assertSame($nameBrandEdit, $brandTransfer->getName());

        return $brandTransfer;
    }

    /**
     * @param BrandTransfer $brandTransfer
     *
     * @depends testBrandSaveCorrectly
     *
     * @return BrandTransfer
     */
    public function testBrandEditSameNameCorrectly(BrandTransfer $brandTransfer): BrandTransfer
    {
        $nameOrigin = $brandTransfer->getName();
        /**
         * @var BrandTransfer $brandResultTransfer
         */
        $this->tester->getFacade()->update($brandTransfer);
        $this->assertSame($nameOrigin, $brandTransfer->getName());

        return $brandTransfer;
    }

    /**
     * @param BrandTransfer $brandTransfer
     *
     * @depends testBrandEditCorrectly
     */
    public function testBrandDeleteCorrectly(BrandTransfer $brandTransfer)
    {
        $brandResultTransfer = $this->tester->getFacade()->delete($brandTransfer);

        $this->assertEmpty($brandResultTransfer);
    }
}
