<?php
namespace Dev\ProductComments\Model;

use Dev\ProductComments\Api\Data\ItemInterface;
use Dev\ProductComments\Api\ItemRepositoryInterface;
use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory as CollectionFactory;

class ItemRepositoryForApi implements ItemRepositoryInterface
{
    private $collectionFactory;

    /**
     * ItemRepository constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param integer $productId
     * @return ItemInterface[]
     */
    public function getList($productId)
    {
        return $this->collectionFactory->create()->addFieldToFilter('entity_id', $productId)->getItems();
    }
}
