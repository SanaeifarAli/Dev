<?php
namespace Dev\ProductComments\ViewModel;

use Dev\ProductComments\Model\Item;
use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductCommentsBlock implements ArgumentInterface
{
    private $collectionFactory;
    private $productFactory;

    protected $_registry;

    public function __construct(
        CollectionFactory $collectionFactory,
        Registry $registry,
        ProductFactory $productFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_registry = $registry;
        $this->productFactory = $productFactory;
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

    /**
     * @param $Id integer
     * @return mixed
     */
    public function getEnableComments($Id)
    {
        return $this->productFactory->create()->load($Id)->getData('product_comments');
    }
}
