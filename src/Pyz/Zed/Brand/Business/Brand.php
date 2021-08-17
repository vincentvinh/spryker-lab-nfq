<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandTransfer;
use Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttributeInterface;
use Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrlInterface;

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
     * @param \Pyz\Zed\Brand\Business\BrandWriterInterface $brandWriterInterface
     * @param \Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttributeInterface $brandAttributeInterface
     * @param \Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrlInterface $brandUrlInterface
     */
    public function __construct(
        BrandWriterInterface $brandWriterInterface,
        BrandAttributeInterface $brandAttributeInterface,
        BrandUrlInterface $brandUrlInterface
    ) {
        $this->brandWriter = $brandWriterInterface;
        $this->brandAttribute = $brandAttributeInterface;
        $this->brandUrl = $brandUrlInterface;
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
    }
}
