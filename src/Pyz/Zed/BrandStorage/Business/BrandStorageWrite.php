<?php

namespace Pyz\Zed\BrandStorage\Business;

use Generated\Shared\Transfer\BrandLocalizedAttributesTransfer;
use Generated\Shared\Transfer\BrandStorageTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Orm\Zed\Brand\Persistence\SpyBrandAttribute;
use Orm\Zed\BrandStorage\Persistence\SpyBrandStorage;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttribute;
use Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttributeInterface;
use Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainerInterface;
use Spryker\Shared\Kernel\Store;

class BrandStorageWrite implements BrandStorageWriteInterface
{
    /**
     * @var \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainerInterface
     */
    protected $brandStorageQueryContainer;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    public function __construct(
        BrandStorageQueryContainerInterface $brandStorageQueryContainer,
        Store $store
    )
    {
        $this->brandStorageQueryContainer = $brandStorageQueryContainer;
        $this->store = $store;
    }

    /**
     * @param array $brandIds
     * @return mixed|void
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function publish(array $brandIds)
    {
        $brandEntities = $this->getBrands($brandIds);
        $brandStorages = $this->getBrandStorages($brandIds);

        $this->storeData($brandEntities, $brandStorages);
    }

    /**
     * @param array $brandStorages
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function storeData(array $brandEntities, array $brandStorages)
    {
        foreach ($brandEntities as $brandEntity) {
            /** @var SpyBrand $brandEntity */
            foreach($brandEntity as $locale =>  $brand) {
                if (isset($brandStorages[$brandEntity->getIdBrand()][$locale])) {
                    $this->setStoreData($brand, $locale, $brandStorages[$brandEntity->getIdBrand()][$locale]);
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
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function getBrands(array $brandIds): array
    {
        $brandEntities = $this->brandStorageQueryContainer->getAllBrandByIds($brandIds);
        $locales = $this->store->getLocales();
        $locales = $this->brandStorageQueryContainer->queryLocalesWithLocaleNames($locales)->toKeyIndex();
        $brandStorageTransfer = [];

        foreach ($brandEntities as $brandEntity) {
            /** @var $brandEntity SpyBrand */
            $brandAttributes = $brandEntity->getAttributes()->toArray();
            foreach ($brandAttributes as $brandAttribute) {
                $localName = $locales[$brandAttribute['FkLocale']];
                $brandAttributeEntity = new BrandLocalizedAttributesTransfer();
                $brandAttributeEntity->fromArray($brandAttribute, true);
                $brandStorageTransfer[$brandEntity->getIdBrand()][$localName->getLocaleName()] = $this->mapToBrandTransfer($brandEntity, $brandAttributeEntity);

            }
        }

        return $brandStorageTransfer;
    }

    /**
     * @param array $brandIds
     *
     * @return array
     */
    protected function getBrandStorages(array $brandIds): array
    {
        $brandStorages = [];
        $brandStorageEntities = $this->brandStorageQueryContainer->getBrandStorageByBrandIds($brandIds);

        foreach ($brandStorageEntities as $brandStorageEntity) {
            /** @var SPyBrandStorage $brandStorageEntity */
            $brandStorages[$brandStorageEntity->getFkBrand()][$brandStorageEntity[$brandStorageEntity->getLocale()]] = $brandStorageEntity;
        }

        return $brandStorages;
    }
    /**
     * @param SpyBrand $brandTransfer
     * @param BrandLocalizedAttributesTransfer $brandLocalizedAttributesTransfer
     *
     * @return BrandStorageTransfer
     */
    protected function mapToBrandTransfer(SpyBrand $brandTransfer, BrandLocalizedAttributesTransfer $brandLocalizedAttributesTransfer): BrandStorageTransfer
    {
        $brandStorageTransfer = new BrandStorageTransfer();
        $brandStorageTransfer->setIdBrand($brandTransfer->getIdBrand());
        $brandStorageTransfer->setName($brandTransfer->getName());
        $brandStorageTransfer->setDescription($brandTransfer->getDescription());
        $brandStorageTransfer->setIsHighlight($brandTransfer->getIsHighlight());
        $brandStorageTransfer->setIsSearchable($brandTransfer->getIsSearchable());
        $brandStorageTransfer->setMetaDescription($brandLocalizedAttributesTransfer->getMetaDescription());

        return $brandStorageTransfer;
    }

    /**
     * @param BrandStorageTransfer $brandStorageTransfer
     * @param $locale
     * @param null| ?SpyBrandStorage $spyBrandStorage
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function setStoreData(BrandStorageTransfer $brandStorageTransfer, $locale, ?SpyBrandStorage  $spyBrandStorage)
    {
        if (empty($spyBrandStorage)) {
            $spyBrandStorage = new SpyBrandStorage();
        }

        $spyBrandStorage->setData($brandStorageTransfer->toArray());
        $spyBrandStorage->setFkBrand($brandStorageTransfer->getIdBrand());
        $spyBrandStorage->setLocale($locale);
        $spyBrandStorage->save();
    }

    /**
     * @param $idBrand
     *
     * @param $idLocale
     */
    protected function getBrandAttribute($idBrand, $idLocale)
    {
        $localizedBrandAttributesEntity = $this
            ->brandStorageQueryContainer
            ->queryAttributeByBrandId($idBrand)
            ->filterByFkLocale($idLocale)
            ->findOneOrCreate();
    }
}
