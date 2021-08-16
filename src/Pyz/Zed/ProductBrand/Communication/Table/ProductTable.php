<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */


namespace Pyz\Zed\ProductBrand\Communication\Table;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Brand\Persistence\Map\SpyProductBrandTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractLocalizedAttributesTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\ProductCategory\Persistence\Map\SpyProductCategoryTableMap;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class ProductTable extends AbstractTable
{
    public const TABLE_IDENTIFIER = 'product-table';
    public const COL_CHECKBOX = 'checkbox';

    /**
     * @var ProductBrandQueryContainerInterface
     */
    protected $productBrandQueryContainer;

    /**
     * @var UtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var LocaleTransfer
     */
    protected $locale;

    /**
     * @var int
     */
    protected $idBrand;

    /**
     * @param ProductBrandQueryContainerInterface $productBrandQueryContainer
     * @param UtilEncodingServiceInterface $utilEncodingService
     * @param LocaleTransfer $locale
     * @param int $idBrand
     */
    public function __construct(
        ProductBrandQueryContainerInterface $productBrandQueryContainer,
        UtilEncodingServiceInterface $utilEncodingService,
        LocaleTransfer $locale,
        int $idBrand
    ) {
        $this->productBrandQueryContainer = $productBrandQueryContainer;
        $this->utilEncodingService = $utilEncodingService;
        $this->locale = $locale;
        $this->idBrand = (int)$idBrand;
        $this->defaultUrl = sprintf('product-table?%s=%d', ProductBrandTable::PARAM_ID_BRAND, $this->idBrand);
        $this->setTableIdentifier(self::TABLE_IDENTIFIER);
    }

    /**
     * @param TableConfiguration $config
     *
     * @return TableConfiguration
     */
    protected function configure(TableConfiguration $config)
    {
        $config->setHeader([
            SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT => 'ID',
            SpyProductAbstractTableMap::COL_SKU => 'SKU',
            SpyProductAbstractLocalizedAttributesTableMap::COL_NAME => 'Name',
            self::COL_CHECKBOX => 'Selected',
        ]);

        $config->setSearchable([
            SpyProductAbstractTableMap::COL_SKU,
            SpyProductAbstractLocalizedAttributesTableMap::COL_NAME,
        ]);

        $config->setSortable([
            SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
            SpyProductAbstractTableMap::COL_SKU,
        ]);

        $config->addRawColumn(self::COL_CHECKBOX);
        $config->setPageLength(10);
        $config->setDefaultSortField(SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT, TableConfiguration::SORT_ASC);

        return $config;
    }

    /**
     * @param TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $query = $this->productBrandQueryContainer
            ->queryProductsAbstractBySearchTermForAssignment(null, $this->idBrand, $this->locale)
            ->setModelAlias('spy_product_abstract');

        $queryResults = $this->runQuery($query, $config);

        $results = [];
        foreach ($queryResults as $product) {
            $info = [
                'id' => $product[SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT],
                'sku' => $product[SpyProductAbstractTableMap::COL_SKU],

                'name' => urlencode($product['name']),
            ];

            $htmlCheckbox = sprintf(
                "<input id='all_products_checkbox_%d' class='all-products-checkbox' type='checkbox' data-info='%s'>",
                $product[SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT],
                $this->utilEncodingService->encodeJson($info)
            );

            $results[] = [
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT => $product[SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT],
                SpyProductAbstractTableMap::COL_SKU => $product[SpyProductAbstractTableMap::COL_SKU],
                SpyProductAbstractLocalizedAttributesTableMap::COL_NAME => $product['name'],
                self::COL_CHECKBOX => $htmlCheckbox,
            ];
        }
        unset($queryResults);

        return $results;
    }
}
