<?php
namespace Dev\ProductComments\Model\Item;

use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory;
use Dev\ProductComments\Model\Item;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;
    protected $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ){
        $this->collection = $contactCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
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

        $data = $this->dataPersistor->get('product_comments');
        if (!empty($data)) {
            $items = $this->collection->getNewEmptyItem();
            $items->setData($data);
            $this->_loadedData[$items->getId()] = $items->getData();
            $this->dataPersistor->clear('product_comments');
        }

        return $this->_loadedData;
    }
}