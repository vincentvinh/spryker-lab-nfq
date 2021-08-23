<?php

namespace Pyz\Client\BrandStorage;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\BrandStorage\BrandStorageFactory getFactory()
 */
class BrandStorageClient extends AbstractClient implements BrandStorageClientInterface
{
    /**
     * @return \Pyz\Client\BrandStorage\Zed\BrandStorageStubInterface
     */
    protected function getZedStub()
    {
        return $this->getFactory()->createZedStub();
    }
}
