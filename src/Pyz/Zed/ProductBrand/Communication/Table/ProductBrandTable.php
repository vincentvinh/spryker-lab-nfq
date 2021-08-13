<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductBrand\Communication\Table;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractLocalizedAttributesTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\ProductBrand\Persistence\Map\SpyProductBrandTableMap;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use Spryker\Zed\ProductBrand\Dependency\Service\ProductBrandToUtilEncodingInterface;
use Spryker\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface;

class ProductBrandTable extends AbstractTable
{
    public const TABLE_IDENTIFIER = 'product-brand-table';
    public const COL_CHECKBOX = 'checkbox';
    public const PARAM_ID_CATEGORY = 'id-brand';

    /**
     * @var \Spryker\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface
     */
    protected $productBrandQueryContainer;

    /**
     * @var \Spryker\Zed\ProductBrand\Dependency\Service\ProductBrandToUtilEncodingInterface
     */
    protected $utilEncodingService;

    /**
     * @var \Generated\Shared\Transfer\LocaleTransfer
     */
    protected $locale;

    /**
     * @var int
     */
    protected $idBrand;

    /**
     * @param \Spryker\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface $productBrandQueryContainer
     * @param \Spryker\Zed\ProductBrand\Dependency\Service\ProductBrandToUtilEncodingInterface $utilEncodingService
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
     * @param int $idBrand
     */
    public function __construct(
        ProductBrandQueryContainerInterface $productBrandQueryContainer,
        ProductBrandToUtilEncodingInterface $utilEncodingService,
        LocaleTransfer $locale,
        $idBrand
    ) {
        $this->productBrandQueryContainer = $productBrandQueryContainer;
        $this->utilEncodingService = $utilEncodingService;
        $this->locale = $locale;
        $this->idBrand = $idBrand;
        $this->defaultUrl = sprintf('product-brand-table?%s=%d', static::PARAM_ID_CATEGORY, $this->idBrand);
        $this->setTableIdentifier(static::TABLE_IDENTIFIER);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config)
    {
        $config->setHeader([
            SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT => 'ID',
            SpyProductAbstractTableMap::COL_SKU => 'SKU',
            SpyProductAbstractLocalizedAttributesTableMap::COL_NAME => 'Name',
            SpyProductBrandTableMap::COL_PRODUCT_ORDER => 'Order',
            static::COL_CHECKBOX => 'Selected',
        ]);
        $config->setSearchable([
            SpyProductAbstractTableMap::COL_SKU,
            SpyProductAbstractLocalizedAttributesTableMap::COL_NAME,
        ]);
        $config->setSortable([
            SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
            SpyProductAbstractTableMap::COL_SKU,
            SpyProductBrandTableMap::COL_PRODUCT_ORDER,
        ]);

        $config->addRawColumn(SpyProductBrandTableMap::COL_PRODUCT_ORDER);
        $config->addRawColumn(static::COL_CHECKBOX);
        $config->setDefaultSortField(SpyProductBrandTableMap::COL_PRODUCT_ORDER, TableConfiguration::SORT_ASC);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $query = $this->productBrandQueryContainer->queryProductsByBrandId($this->idBrand, $this->locale);
        $query->clearOrderByColumns();
        $query->setModelAlias('spy_product_abstract');

        $queryResults = $this->runQuery($query, $config);

        $results = [];
        foreach ($queryResults as $productBrand) {
            $results[] = [
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT => $productBrand['id_product_abstract'],
                SpyProductAbstractTableMap::COL_SKU => $productBrand['sku'],
                SpyProductAbstractLocalizedAttributesTableMap::COL_NAME => $productBrand['name'],
                SpyProductBrandTableMap::COL_PRODUCT_ORDER => $this->getOrderHtml($productBrand),
                static::COL_CHECKBOX => $this->getCheckboxHtml($productBrand),
            ];
        }
        unset($queryResults);

        return $results;
    }

    /**
     * @param array $productBrand
     *
     * @return string
     */
    protected function getCheckboxHtml(array $productBrand)
    {
        $info = [
            'id' => $productBrand['id_product_abstract'],
            'sku' => $productBrand['sku'],
            'name' => urlencode($productBrand['name']),
        ];

        return sprintf(
            "<input id='product_brand_checkbox_%d' class='product_brand_checkbox' type='checkbox' checked='checked' data-info='%s'>",
            $productBrand['id_product_abstract'],
            $this->utilEncodingService->encodeJson($info)
        );
    }

    /**
     * @param array $productBrand
     *
     * @return string
     */
    protected function getOrderHtml(array $productBrand)
    {
        $info = [
            'id' => $productBrand['id_product_abstract'],
        ];

        return sprintf(
            "<input type='text' value='%d' id='product_brand_order_%d' class='product_brand_order' size='4' data-info='%s'>",
            $productBrand['product_order'],
            $productBrand['id_product_abstract'],
            $this->utilEncodingService->encodeJson($info)
        );
    }
}
