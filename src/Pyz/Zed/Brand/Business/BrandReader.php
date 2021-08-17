<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandTransfer;
use Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface;
use Pyz\Zed\Brand\Persistence\BrandRepositoryInterface;

class BrandReader implements BrandReaderInterface
{
    /**
     * @var \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface $repository
     */
    protected $repository;

    /**
     * @var \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface $queryContainer
     */
    protected $queryContainer;

    /**
     * @param \Pyz\Zed\Brand\Persistence\BrandRepositoryInterface $repository
     * @param \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface $brandQueryContainer
     */
    public function __construct(
        BrandRepositoryInterface $repository,
        BrandQueryContainerInterface $brandQueryContainer
    ) {
        $this->repository = $repository;
        $this->queryContainer = $brandQueryContainer;
    }

    /**
     * @param int $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    public function getBrand(int $idBrand): ?BrandTransfer
    {
        return $this->repository->findBrandById($idBrand);
    }
}
