<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandTransfer;
use Orm\Zed\Brand\Persistence\SpyBrand;
use Pyz\Zed\Brand\Business\Exception\MissingBrandException;
use Pyz\Zed\Brand\Persistence\BrandEntityManagerInterface;
use Pyz\Zed\Brand\Persistence\BrandQueryContainer;

class BrandWriter implements BrandWriterInterface
{
    /**
     * @var \Pyz\Zed\Brand\Persistence\BrandEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \Pyz\Zed\Brand\Persistence\BrandQueryContainer
     */
    protected $brandQueryContainer;

    /**
     * @param \Pyz\Zed\Brand\Persistence\BrandEntityManagerInterface $entityManager
     * @param \Pyz\Zed\Brand\Persistence\BrandQueryContainer $brandQueryContainer
     */
    public function __construct(
        BrandEntityManagerInterface $entityManager,
        BrandQueryContainer $brandQueryContainer
    ) {
        $this->entityManager = $entityManager;
        $this->brandQueryContainer = $brandQueryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function delete(BrandTransfer $brandTransfer)
    {
        $this->entityManager->delete($brandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function create(BrandTransfer $brandTransfer)
    {
        $this->entityManager->create($brandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function update(BrandTransfer $brandTransfer)
    {
        $brandEntity = $this->getBrandEntity($brandTransfer->getIdBrand());
        $brandEntity->fromArray($brandTransfer->toArray());
        $brandEntity->save();
    }

    /**
     * @param int $idBrand
     *
     * @throws \Pyz\Zed\Brand\Business\Exception\MissingBrandException
     *
     * @return \Orm\Zed\Brand\Persistence\SpyBrand
     */
    protected function getBrandEntity(int $idBrand): SpyBrand
    {
        $brandEntity = $this
            ->brandQueryContainer
            ->queryBrandById($idBrand)
            ->findOne();

        if (!$brandEntity) {
            throw new MissingBrandException(sprintf('Could not find brand for ID "%s"', $idBrand));
        }

        return $brandEntity;
    }
}
