<?php

namespace Pyz\Zed\BrandSearch\Business\Writer;

use ArrayObject;
use Generated\Shared\Transfer\BrandLocalizedAttributeTransfer;
use Generated\Shared\Transfer\BrandSearchTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductBrandAbstractTransfer;
use Generated\Shared\Transfer\ProductImageSetTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Orm\Zed\BrandSearch\Persistence\SpyBrandSearch;
use Propel\Runtime\Exception\PropelException;
use Pyz\Zed\BrandSearch\Persistence\BrandSearchQueryContainerInterface;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Shared\Kernel\Store;

class BrandSearchWriter implements BrandSearchWriterInterface
{
    /**
     * @var Store
     */
    protected Store $store;

    /**
     * @var BrandSearchQueryContainerInterface
     */
    private BrandSearchQueryContainerInterface $brandSearchQueryContainer;

    private UtilEncodingServiceInterface $utilEncoding;

    /**
     * @param BrandSearchQueryContainerInterface $brandSearchQueryContainer
     * @param Store $store
     * @param UtilEncodingServiceInterface $utilEncoding
     */
    public function __construct(
        BrandSearchQueryContainerInterface $brandSearchQueryContainer,
        Store $store,
        UtilEncodingServiceInterface $utilEncoding
    ) {
        $this->store = $store;
        $this->brandSearchQueryContainer = $brandSearchQueryContainer;
        $this->utilEncoding = $utilEncoding;
    }

    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function publish(array $brandIds)
    {
        $brandSearchTransferCollection = $this->getBrandSearchTransferCollection($brandIds);
        $brandSearchesWithIdAndLocales = $this->getBrandSearches($brandIds);

        if (empty($brandSearchTransferCollection)) {
            $this->deleteSearchData($brandSearchesWithIdAndLocales);
        }

        $this->storeData($brandSearchTransferCollection, $brandSearchesWithIdAndLocales);
    }

    /**
     * @param array $brandIds
     *
     * @return void
     */
    public function unPublish(array $brandIds)
    {
        $brandSearches = $this->getBrandSearches($brandIds);
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
            /** @var BrandSearchTransfer $brandSearchTransfer */
            foreach ($brandEntity as $locale => $brandSearchTransfer) {
                if (isset($brandSearches[$brandSearchTransfer->getIdBrand()][$locale])) {
                    $this->setStoreData($brandSearchTransfer, $locale, $brandSearches[$brandSearchTransfer->getIdBrand()][$locale]);
                    continue;
                }

                $this->setStoreData($brandSearchTransfer, $locale, null);
            }
        }
    }

    /**
     * @param array $brandIds
     *
     * @return array
     */
    protected function getBrandSearchTransferCollection(array $brandIds): array
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
                $productAbstractIds = $this->brandSearchQueryContainer
                    ->getQueryProductAbstractIdsByBrandLocale(
                        $brandEntity->getIdBrand(),
                        $brandAttribute['FkLocale']
                    )->toArray();
                $brandAttributeEntity->fromArray($brandAttribute, true);
                $brandSearchTransfer[$brandEntity->getIdBrand()][$localName->getLocaleName()] = $this->mapToBrandTransfer($brandEntity, $brandAttributeEntity, $productAbstractIds, $localName->getLocaleName());
            }
        }

        return $brandSearchTransfer;
    }

    /**
     * @param array $brandIds
     *
     * @return array
     */
    protected function getBrandSearches(array $brandIds): array
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
     * @param array $productAbstractIds
     * @param $localeName
     * @return BrandSearchTransfer
     */
    protected function mapToBrandTransfer(
        SpyBrand $brandTransfer,
        BrandLocalizedAttributeTransfer $brandLocalizedAttributesTransfer,
        array $productAbstractIds,
        $localeName
    ): BrandSearchTransfer
    {
        $brandSearchTransfer = new BrandSearchTransfer();
        $brandSearchTransfer->setIdBrand($brandTransfer->getIdBrand());
        $brandSearchTransfer->setName($brandTransfer->getName());

        $brandSearchTransfer->setLocale($localeName);
        $brandSearchTransfer->setDescription($brandTransfer->getDescription());
        $brandSearchTransfer->setIsHighlight($brandTransfer->getIsHighlight());
        $brandSearchTransfer->setIsSearchable($brandTransfer->getIsSearchable());
        $brandSearchTransfer->setMetaDescription($brandLocalizedAttributesTransfer->getMetaDescription());
        $brandSearchTransfer->setProductAbstractIds($productAbstractIds);

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
        $spyBrandSearch->setStructuredData($this->utilEncoding->encodeJson($brandSearchTransfer->toArray()));
        $spyBrandSearch->setFkBrand($brandSearchTransfer->getIdBrand());
        $spyBrandSearch->setLocale($locale);
        $spyBrandSearch->save();
    }
}
