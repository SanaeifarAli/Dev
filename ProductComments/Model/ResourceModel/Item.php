<?php

namespace Dev\ProductComments\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Item extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('product_comments', 'product_comments_id');
    }

    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $first_name=$object->getFirst_name();
        if (strlen(trim($first_name))<2) {
            throw new LocalizedException(__('First Name should have at least 2 characters!'));
        }
        return $this;
    }
}
