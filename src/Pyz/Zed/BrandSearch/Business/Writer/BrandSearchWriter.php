<?php

namespace Pyz\Zed\BrandSearch\Business\Writer;

use Generated\Shared\Transfer\BrandLocalizedAttributesTransfer;
use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandSearchTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Orm\Zed\BrandSearch\Persistence\SpyBrandSearch;
use Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainerInterface;
use Spryker\Shared\Kernel\Store;

class BrandSearchWriter implements BrandSearchWriterInterface
{
    /**
     * @var Store
     */
    protected $store;
    /**
     * @var BrandSearchQueryContainerInterface
     */
    private BrandSearchQueryContainerInterface $brandSearchQueryContainer;

    /**
     * @param BrandSearchQueryContainerInterface $brandSearchQueryContainer
     * @param Store $store
     */
    public function __construct(
        BrandSearchQueryContainerInterface $brandSearchQueryContainer,
        Store $store
    ) {
        $this->store = $store;
        $this->brandSearchQueryContainer = $brandSearchQueryContainer;
    }

    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function publish(array $brandIds)
    {
        $brandEntities = $this->getBrands($brandIds);
        $brandSearchesWithIdAndLocales = $this->getBrandSearchs($brandIds);

        if (empty($brandEntities)) {
            $this->deleteSearchData($brandSearchesWithIdAndLocales);
        }

        $this->storeData($brandEntities, $brandSearchesWithIdAndLocales);
    }

    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function unpublish(array $brandIds)
    {
        $brandSearches = $this->getBrandSearchs($brandIds);
        $this->deleteSearchData($brandSearches);
    }

    /**
     * @param array $brandSearchesWithIdAndLocales
     *
     * @return void
     */
    protected function deleteSearchData(array $brandSearchesWithIdAndLocales)
    {
        foreach ($brandSearchesWithIdAndLocales as $brandSearchesWithIdAndLocale) {
            foreach ($brandSearchesWithIdAndLocale as $brandSearch) {
                $brandSearch->delete();
            }
        }
    }

    /**
     * @param array $brandEntities
     * @param array $brandSearches
     *
     * @return void
     */
    protected function storeData(array $brandEntities, array $brandSearches)
    {
        foreach ($brandEntities as $brandEntity) {
            /** @var SpyBrand $brandEntity */
            /** @var BrandSearchTransfer $brand */
            foreach ($brandEntity as $locale => $brand) {
                if (isset($brandSearches[$brand->getIdBrand()][$locale])) {
                    $this->setStoreData($brand, $locale, $brandSearches[$brand->getIdBrand()][$locale]);
                    continue;
                }

                $this->setStoreData($brand, $locale, null);
            }
        }
    }

    /**
     * @param array $brandIds
     *
     * @return array
     */
    protected function getBrands(array $brandIds): array
    {
        $brandEntities = $this->brandSearchQueryContainer->getAllBrandByIds($brandIds);
        $locales = $this->store->getLocales();
        $locales = $this->brandSearchQueryContainer->queryLocalesWithLocaleNames($locales)->toKeyIndex();
        $brandSearchTransfer = [];

        foreach ($brandEntities as $brandEntity) {
            /** @var SpyBrand $brandEntity */
            $brandAttributes = $brandEntity->getAttributes()->toArray();
            foreach ($brandAttributes as $brandAttribute) {
                $localName = $locales[$brandAttribute['FkLocale']];
                $brandAttributeEntity = new BrandLocalizedAttributeTransfer();
                $brandAttributeEntity->fromArray($brandAttribute, true);
                $brandSearchTransfer[$brandEntity->getIdBrand()][$localName->getLocaleName()] = $this->mapToBrandTransfer($brandEntity, $brandAttributeEntity);
            }
        }

        return $brandSearchTransfer;
    }

    /**
     * @param array $brandIds
     *
     * @return array
     */
    protected function getBrandSearchs(array $brandIds): array
    {
        $brandSearches = [];
        $brandSearchEntities = $this->brandSearchQueryContainer->getBrandSearchByBrandIds($brandIds);

        foreach ($brandSearchEntities as $brandSearchEntity) {
            /** @var SpyBrandSearch $brandSearchEntity */
            $brandSearches[$brandSearchEntity->getFkBrand()][$brandSearchEntity->getLocale()] = $brandSearchEntity;
        }

        return $brandSearches;
    }

    /**
     * @param SpyBrand $brandTransfer
     * @param BrandLocalizedAttributeTransfer $brandLocalizedAttributesTransfer
     *
     * @return BrandSearchTransfer
     */
    protected function mapToBrandTransfer(SpyBrand $brandTransfer, BrandLocalizedAttributeTransfer $brandLocalizedAttributesTransfer): BrandSearchTransfer
    {
        $brandSearchTransfer = new BrandSearchTransfer();
        $brandSearchTransfer->setIdBrand($brandTransfer->getIdBrand());
        $brandSearchTransfer->setName($brandTransfer->getName());
        $brandSearchTransfer->setDescription($brandTransfer->getDescription());
        $brandSearchTransfer->setIsHighlight($brandTransfer->getIsHighlight());
        $brandSearchTransfer->setIsSearchable($brandTransfer->getIsSearchable());
        $brandSearchTransfer->setMetaDescription($brandLocalizedAttributesTransfer->getMetaDescription());

        return $brandSearchTransfer;
    }

    /**
     * @param BrandSearchTransfer $brandSearchTransfer
     * @param string $locale
     * @param SpyBrandSearch|null $spyBrandSearch
     *
     * @return void
     */
    protected function setStoreData(BrandSearchTransfer $brandSearchTransfer, string $locale, ?SpyBrandSearch $spyBrandSearch)
    {
        if (empty($spyBrandSearch)) {
            $spyBrandSearch = new SpyBrandSearch();
        }

        $spyBrandSearch->setData($brandSearchTransfer->toArray());
        $spyBrandSearch->setFkBrand($brandSearchTransfer->getIdBrand());
        $spyBrandSearch->setLocale($locale);
        $spyBrandSearch->save();
    }
}
