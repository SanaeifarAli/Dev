<?php
namespace Dev\ProductComments\Model\ResourceModel\Item;

use Dev\ProductComments\Model\Item;
use Dev\ProductComments\Model\ResourceModel\Item as ItemAlias;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'product_comments_id';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Item::class,
            ItemAlias::class
        );
    }
}
