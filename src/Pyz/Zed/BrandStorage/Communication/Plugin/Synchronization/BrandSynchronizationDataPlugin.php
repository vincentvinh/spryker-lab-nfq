<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\BrandStorage\Communication\Plugin\Synchronization;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Pyz\Shared\BrandStorage\BrandStorageConstants;
use Spryker\Shared\CategoryPageSearch\CategoryPageSearchConstants;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SynchronizationExtension\Dependency\Plugin\SynchronizationDataQueryContainerPluginInterface;

/**
 * @method \Pyz\Zed\BrandStorage\Persistence\BrandStorageQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\BrandStorage\Business\BrandStorageFacadeInterface getFacade()
 * @method \Pyz\Zed\BrandStorage\Communication\BrandStorageCommunicationFactory getFactory()
 * @method \Pyz\Zed\BrandStorage\BrandStorageConfig getConfig()
 */
class BrandSynchronizationDataPlugin extends AbstractPlugin implements SynchronizationDataQueryContainerPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceName(): string
    {
        return BrandStorageConstants::BRAND_RESOURCE_NAME;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return bool
     */
    public function hasStore(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $ids
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria|null
     */
    public function queryData($ids = []): ?ModelCriteria
    {
        $query = $this->getQueryContainer()->getBrandStorageByBrandIds($ids);

        if ($ids === []) {
            $query->clear();
        }

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return array
     */
    public function getParams(): array
    {
        return ['type' => 'page'];
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getQueueName(): string
    {
        return BrandStorageConstants::BRAND_SYNC_QUEUE;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string|null
     */
    public function getSynchronizationQueuePoolName(): ?string
    {
        return $this->getFactory()->getConfig()->getBrandSynchronizationPoolName();
    }
}
