<?php

namespace Pyz\Client\BrandStorage;

use Pyz\Client\BrandStorage\Zed\BrandStorageStub;
use Spryker\Client\Kernel\AbstractFactory;

class BrandStorageFactory extends AbstractFactory
{

    /**
     * @return \Pyz\Client\BrandStorage\Zed\BrandStorageStubInterface
     */
    public function createZedStub()
    {
        return new BrandStorageStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient()
    {
        return $this->getProvidedDependency(BrandStorageDependencyProvider::CLIENT_ZED_REQUEST);
    }

}
