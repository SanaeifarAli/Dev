<?php

namespace Dev\ProductComments\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Exception\LocalizedException;

class Item extends AbstractDb
{
    private $_eventManager;
    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('product_comments', 'product_comments_id');
    }

    /**
     * @param AbstractModel $object
     * @return $this|AbstractDb
     * @throws LocalizedException
     */
    protected function _beforeSave(AbstractModel $object)
    {
        $first_name=$object->getFirst_name();
        if (strlen(trim($first_name))<2) {
            throw new LocalizedException(__('First Name should have at least 2 characters!'));
        }
        return $this;
    }
}
