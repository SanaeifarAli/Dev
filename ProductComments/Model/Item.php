<?php

namespace Dev\ProductComments\Model;
use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dev\ProductComments\Model\ResourceModel\Item');
    }
}