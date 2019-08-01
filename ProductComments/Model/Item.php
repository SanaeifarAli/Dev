<?php

namespace Dev\ProductComments\Model;
use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    const STATUS_APPROVED = 1;
    const STATUS_NOTAPPROVED = 0;

    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dev\ProductComments\Model\ResourceModel\Item');
    }
    public function getAvailableStatuses()
    {
        return [self::STATUS_APPROVED => __('Approved'), self::STATUS_NOTAPPROVED => __('Not Approved')];
    }

  /*  public function _beforeSave()
    {
        // set current date if added at data is not defined
        if (is_null($this->getCreatedAt())) {
            $this->setCreatedAt($this->_date->gmtDate());
        }
    }*/
}