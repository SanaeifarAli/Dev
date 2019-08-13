<?php
namespace Dev\ProductComments\Block;

use Dev\ProductComments\Model\Item;
use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class ProductCommentsBlock extends Template
{
    private $collectionFactory;
    protected $_registry;

    /**
     * ProductCommentsBlock constructor.
     *
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        Registry $registry,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_registry = $registry;
        parent::__construct(
            $context,
            $data
        );
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
