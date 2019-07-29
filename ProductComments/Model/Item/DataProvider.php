<?php
namespace Dev\ProductComments\Model\Item;

use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory;
use Dev\ProductComments\Model\Item;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        array $meta = [],
        array $data = []
    ){
        $this->collection = $contactCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if(isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->collection->getItems();

        foreach($items as $comment)
        {
            $this->_loadedData[$comment->getId()] = $comment->getData();
        }

        return $this->_loadedData;
    }

}
