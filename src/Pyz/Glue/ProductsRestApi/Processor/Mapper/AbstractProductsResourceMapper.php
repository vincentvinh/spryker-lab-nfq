<?php

namespace Pyz\Glue\ProductsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\AbstractProductsRestAttributesTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface;
use Spryker\Glue\ProductsRestApi\Processor\Mapper\AbstractProductsResourceMapper as SprykerAbstractProductsResourceMapper;

class AbstractProductsResourceMapper extends SprykerAbstractProductsResourceMapper
{


    private BrandQueryContainerInterface $brandQueryContainer;

    public function __construct(BrandQueryContainerInterface $brandQueryContainer)
    {
        $this->brandQueryContainer = $brandQueryContainer;
    }

    /**
     * @param array $abstractProductData
     *
     * @return \Generated\Shared\Transfer\AbstractProductsRestAttributesTransfer
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function mapAbstractProductsDataToAbstractProductsRestAttributes(array $abstractProductData): AbstractProductsRestAttributesTransfer
    {
        $restAbstractProductsAttributesTransfer = parent::mapAbstractProductsDataToAbstractProductsRestAttributes($abstractProductData);

        $brand = $this->brandQueryContainer->queryBrandByProductAbstractSku($abstractProductData['sku'])->toArray();
        $brandTransfer = new BrandTransfer();
        $brandTransfer->fromArray($brand, true);
        $restAbstractProductsAttributesTransfer->setBrand($brandTransfer);

        return $restAbstractProductsAttributesTransfer;
    }
}
