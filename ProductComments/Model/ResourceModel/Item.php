<?php

namespace Dev\ProductComments\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Item extends AbstractDb
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('product_comments', 'product_comments_id');
    }
}