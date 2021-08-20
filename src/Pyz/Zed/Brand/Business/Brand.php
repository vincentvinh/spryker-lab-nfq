<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttributeInterface;
use Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrlInterface;
use Pyz\Zed\Brand\Dependency\BrandEvents;
use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class Brand
{
    /**
     * @var \Pyz\Zed\Brand\Business\BrandWriterInterface
     */
    protected $brandWriter;

    /**
     * @var \Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttributeInterface
     */
    protected $brandAttribute;

    /**
     * @var \Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrlInterface
     */
    protected $brandUrl;

    /**
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected $eventFacade;

    /**
     * @param \Pyz\Zed\Brand\Business\BrandWriterInterface $brandWriterInterface
     * @param \Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttributeInterface $brandAttributeInterface
     * @param \Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrlInterface $brandUrlInterface
     * @param \Spryker\Zed\Event\Business\EventFacadeInterface $eventFacade
     */
    public function __construct(
        BrandWriterInterface $brandWriterInterface,
        BrandAttributeInterface $brandAttributeInterface,
        BrandUrlInterface $brandUrlInterface,
        EventFacadeInterface $eventFacade
    ) {
        $this->brandWriter = $brandWriterInterface;
        $this->brandAttribute = $brandAttributeInterface;
        $this->brandUrl = $brandUrlInterface;
        $this->eventFacade = $eventFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function create(BrandTransfer $brandTransfer)
    {
        $this->brandWriter->create($brandTransfer);
        $this->brandAttribute->create($brandTransfer);
        $this->brandUrl->create($brandTransfer);

        $this->triggerBulk($brandTransfer->requireIdBrand()->getIdBrand());
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function update(BrandTransfer $brandTransfer)
    {
        $this->brandWriter->update($brandTransfer);
        $this->brandAttribute->update($brandTransfer);
        $this->brandUrl->update($brandTransfer);

        $this->triggerBulk($brandTransfer->requireIdBrand()->getIdBrand());
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return void
     */
    public function delete(BrandTransfer $brandTransfer)
    {
        $this->brandAttribute->delete($brandTransfer);
        $this->brandUrl->delete($brandTransfer);
        $this->brandWriter->delete($brandTransfer);

//        $this->triggerBulk($brandTransfer->requireIdBrand()->getIdBrand());
    }

    /**
     * @param int $brandIdToTrigger
     *
     * @return void
     */
    protected function triggerBulk(int $brandIdToTrigger): void
    {
        $eventTransfers[] = (new EventEntityTransfer())->setId($brandIdToTrigger);

        $this->eventFacade->triggerBulk(BrandEvents::BRAND_PUBLISH, $eventTransfers);
    }
}
