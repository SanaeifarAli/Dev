<?php
namespace Dev\ProductComments\Model\ResourceModel\Item\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Psr\Log\LoggerInterface as Logger;


class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    /**
     * Collection constructor.
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'product_comments',
        $resourceModel = 'Dev\ProductComments\Model\ResourceModel\Item'
    ){
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $mainTable,
            $resourceModel
        );
    }
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()
            ->columns('csi.value')
            ->joinLeft(
                ['csi' => $this->getTable('catalog_product_entity_varchar')],
                'csi.entity_id = main_table.entity_id and attribute_id = 
                (SELECT attribute_id FROM eav_attribute WHERE attribute_code = "name" AND entity_type_id = 4)',
                []
            );
    }
}
