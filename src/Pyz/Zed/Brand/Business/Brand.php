<?php

namespace Pyz\Zed\Brand\Business;

use Generated\Shared\Transfer\BrandTransfer;
use Pyz\Zed\Brand\Business\Model\BrandAttribute\BrandAttributeInterface;
use Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrl;
use Pyz\Zed\Brand\Business\Model\BrandUrl\BrandUrlInterface;

class Brand
{
    /**
     * @var BrandReaderInterface
     */
    protected $brandReader;

    /**
     * @var BrandWriterInterface
     */
    protected $brandWriter;

    /**
     * @var BrandAttributeInterface
     */
    protected $brandAttribute;

    /**
     * @var BrandUrl
     */
    protected $brandUrl;

    /**
     * @param BrandReaderInterface $brandReaderInterface
     * @param BrandWriterInterface $brandWriterInterface
     * @param BrandAttributeInterface $brandAttributeInterface
     * @param BrandUrlInterface $brandUrlInterface
     */
    public function __construct(
        BrandReaderInterface $brandReaderInterface,
        BrandWriterInterface $brandWriterInterface,
        BrandAttributeInterface $brandAttributeInterface,
        BrandUrlInterface $brandUrlInterface
    ) {
        $this->brandReader = $brandReaderInterface;
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

    /**
     * @return void
     */
    public function deleteAll()
    {
        $this->brandWriter->deleteAll();
    }
}
