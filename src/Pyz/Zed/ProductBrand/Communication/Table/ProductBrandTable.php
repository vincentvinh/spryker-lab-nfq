<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBrand\Communication\Table;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractLocalizedAttributesTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class ProductBrandTable extends AbstractTable
{
    public const TABLE_IDENTIFIER = 'product-category-table';
    public const COL_CHECKBOX = 'checkbox';
    public const PARAM_ID_BRAND = 'id-brand';

    /**
     * @var \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface
     */
    protected $productBrandQueryContainer;

    /**
     * @var \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
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
     * @param \Pyz\Zed\ProductBrand\Persistence\ProductBrandQueryContainerInterface $productBrandQueryContainer
     * @param \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface $utilEncodingService
     * @param \Generated\Shared\Transfer\LocaleTransfer $locale
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
        $this->idBrand = $idBrand;
        $this->defaultUrl = sprintf('product-brand-table?%s=%d', static::PARAM_ID_BRAND, $this->idBrand);
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
            static::COL_CHECKBOX => 'Selected',
        ]);
        $config->setSearchable([
            SpyProductAbstractTableMap::COL_SKU,
            SpyProductAbstractLocalizedAttributesTableMap::COL_NAME,
        ]);
        $config->setSortable([
            SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
            SpyProductAbstractTableMap::COL_SKU,
        ]);

        $config->addRawColumn(static::COL_CHECKBOX);

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
        $query->setModelAlias('spy_product_abstract');

        $queryResults = $this->runQuery($query, $config);

        $results = [];
        foreach ($queryResults as $productBrand) {
            $results[] = [
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT => $productBrand['id_product_abstract'],
                SpyProductAbstractTableMap::COL_SKU => $productBrand['sku'],
                SpyProductAbstractLocalizedAttributesTableMap::COL_NAME => $productBrand['name'],
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
            "<input id='product_category_checkbox_%d' class='product_category_checkbox' type='checkbox' checked='checked' data-info='%s'>",
            $productBrand['id_product_abstract'],
            $this->utilEncodingService->encodeJson($info)
        );
    }
}
