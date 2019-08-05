<?php
namespace Dev\ProductComments\Model;

use Magento\Framework\Model\AbstractModel;
use Dev\ProductComments\Model\ResourceModel\Item as ResourceItem;

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
        $this->_init(ResourceItem::class);
    }
    public function getAvailableStatuses()
    {
        return [self::STATUS_APPROVED => __('Approved'), self::STATUS_NOTAPPROVED => __('Not Approved')];
    }
}
