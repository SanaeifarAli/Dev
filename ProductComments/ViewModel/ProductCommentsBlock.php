<?php
namespace Dev\ProductComments\ViewModel;

use Dev\ProductComments\Model\Item;
use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductCommentsBlock implements ArgumentInterface
{
    private $collectionFactory;
    protected $_registry;

    public function __construct(
        CollectionFactory $collectionFactory,
        Registry $registry
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_registry = $registry;
    }

    /**
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->collectionFactory->create()->addFieldToFilter('status', '1');
    }

    /**
     * @return string
     */
    public function getFormAction()
    {
        return 'product_comments/index/save';
    }
}
