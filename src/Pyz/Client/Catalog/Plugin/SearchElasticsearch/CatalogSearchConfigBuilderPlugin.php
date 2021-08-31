<?php

namespace Pyz\Client\Catalog\Plugin\SearchElasticsearch;

use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\FacetConfigTransfer;
use Generated\Shared\Transfer\SearchConfigurationTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchConfigBuilderPluginInterface;
use Spryker\Shared\Search\SearchConfig;

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
            ->setName('brand')
            ->setParameterName('brand')
            ->setFieldName(PageIndexMap::BRAND)
            ->setType(SearchConfig::FACET_TYPE_RANGE);

        $searchConfigurationTransfer->addFacetConfigItem($priceFacetConfigTransfer);

        return $searchConfigurationTransfer;
    }
}
