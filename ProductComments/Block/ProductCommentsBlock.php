<?php
namespace Dev\ProductComments\Block;

use Magento\Framework\View\Element\Template;
use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory;

class ProductCommentsBlock extends Template
{

    private $collectionFactory;
    protected $_registry;
    /**
     * ProductCommentsBlock constructor.
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(Template\Context $context,
                                CollectionFactory $collectionFactory,
                                \Magento\Framework\Registry $registry,
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
     * @param $id
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    /**
     * @return \Dev\ProductComments\Model\Item[]
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
        return 'productcomments/index/save';
    }
}