<?php

namespace Pyz\Zed\Brand\Communication\Table;

use Pyz\Shared\Brand\BrandConstants;
use Pyz\Zed\Brand\Business\BrandFacadeInterface;
use Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class BrandsTable extends AbstractTable
{
    public const ACTIONS = 'Actions';
    public const ID_BRAND = 'id_brand';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const LOGO = 'logo';
    public const SEARCHABLE = 'is_searchable';
    public const HIGHLIGHTED = 'is_highlight';

    /**
     * @var \Pyz\Zed\Brand\Business\BrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @var \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface
     */
    protected $brandQueryContainer;

    /**
     * @param \Pyz\Zed\Brand\Business\BrandFacadeInterface $brandFacade
     * @param \Pyz\Zed\Brand\Persistence\BrandQueryContainerInterface $brandQueryContainer
     */
    public function __construct(
        BrandFacadeInterface $brandFacade,
        BrandQueryContainerInterface $brandQueryContainer
    ) {
        $this->brandFacade = $brandFacade;
        $this->brandQueryContainer = $brandQueryContainer;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            static::NAME => 'Name',
            static::DESCRIPTION => 'Description',
            static::LOGO => 'Logo',
            static::SEARCHABLE => 'Searchable',
            static::HIGHLIGHTED => 'Highlighted',
            static::ACTIONS => 'Actions',
        ]);

        $config->setSearchable([
            static::NAME,
            static::DESCRIPTION,
        ]);

        $config->setRawColumns([
            static::LOGO,
            static::ACTIONS,
        ]);

        $config->setDefaultSortField(static::NAME, TableConfiguration::SORT_DESC);
        $config->setSortable([static::NAME]);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $result = [];
        $idLocale = $this->brandFacade->getCurrentLocale()->getIdLocale();
        $brandQuery = $this->brandQueryContainer->queryListBrand($idLocale);

        $data = $this->runQuery($brandQuery, $config);

        foreach ($data as $brand) {
            $result[] = [
                static::NAME => $brand[static::NAME],
                static::DESCRIPTION => $brand[static::DESCRIPTION],
                static::LOGO => $this->generateImageViewBrand($brand[static::LOGO]),
                static::SEARCHABLE => $this->yesNoOutput($brand[static::SEARCHABLE]),
                static::HIGHLIGHTED => $this->yesNoOutput($brand[static::HIGHLIGHTED]),
                static::ACTIONS => $this->generateBrandViewButton($brand[static::ID_BRAND]) . ' ' . $this->generateEditBrandButton($brand[static::ID_BRAND]) . ' ' . $this->generateBrandRemoveButton($brand[static::ID_BRAND]),
            ];
        }

        return $result;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function generateEditBrandButton(int $id): string
    {
        return $this->generateEditButton(
            Url::generate('/brand/edit', [
                BrandConstants::PARAM_ID_BRAND => $id,
            ]),
            'Edit'
        );
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function generateBrandRemoveButton(int $id): string
    {
        return $this->generateRemoveButton(
            Url::generate('/brand/delete', [
                BrandConstants::PARAM_ID_BRAND => $id,
            ]),
            'Delete'
        );
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function generateBrandViewButton(int $id): string
    {
        return $this->generateViewButton(
            Url::generate('/brand/view', [
                BrandConstants::PARAM_ID_BRAND => $id,
            ]),
            'View'
        );
    }

    /**
     * @param bool $condition
     *
     * @return string
     */
    protected function yesNoOutput(bool $condition): string
    {
        if ($condition === true) {
            return 'Yes';
        }

        return 'No';
    }

    /**
     * @param string|null $imageUrl
     *
     * @return string
     */
    protected function generateImageViewBrand(?string $imageUrl): string
    {
        if (!empty($imageUrl)) {
            return $imageUrl;
        }

        return '';
    }
}
