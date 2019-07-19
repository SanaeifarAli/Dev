<?php
namespace Dev\ProductComments\Block;

use Magento\Framework\View\Element\Template;
use Dev\ProductComments\Model\ResourceModel\Item\Collection;
use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory;

class ProductCommentsBlock extends Template
{

    private $collectionFactory;

    /**
     * ProductCommentsBlock constructor.
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(Template\Context $context,
                                CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @return \Dev\ProductComments\Model\Item[]
     */
    public function getItems()
    {
        return $this->collectionFactory->create()->get;
    }
}