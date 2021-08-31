<?php

namespace Pyz\Client\Catalog\Plugin\SearchElasticsearch;

use Generated\Shared\DataBuilder\FacetConfigBuilder;
use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\FacetConfigTransfer;
use Generated\Shared\Transfer\SearchConfigurationTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchConfigBuilderPluginInterface;

/**
 * @method \Spryker\Client\Catalog\CatalogFactory getFactory()
 */
class CatalogSearchConfigBuilderPlugin extends AbstractPlugin implements SearchConfigBuilderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\SearchConfigurationTransfer $searchConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\SearchConfigurationTransfer
     */
    public function buildConfig(SearchConfigurationTransfer $searchConfigurationTransfer): SearchConfigurationTransfer
    {
        $searchConfigurationTransfer = $this->buildFacetConfig($searchConfigurationTransfer);

        return $searchConfigurationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SearchConfigurationTransfer $searchConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\SearchConfigurationTransfer
     */
    protected function buildFacetConfig(SearchConfigurationTransfer $searchConfigurationTransfer): SearchConfigurationTransfer
    {
        $priceFacetConfigTransfer = (new FacetConfigTransfer())
            ->setName('price')
            ->setParameterName('price')
            ->setFieldName(PageIndexMap::INTEGER_FACET)
            ->setType(FacetConfigBuilder::TYPE_PRICE_RANGE);

        $searchConfigurationTransfer->addFacetConfigItem($priceFacetConfigTransfer);

        return $searchConfigurationTransfer;
    }
}
