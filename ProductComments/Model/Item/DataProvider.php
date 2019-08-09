<?php
namespace Dev\ProductComments\Model\Item;

use Dev\ProductComments\Model\ResourceModel\Item\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Request\Http as HttpAlias;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;
    protected $dataPersistor;
    private $request;
    private $scopeConfig;

    /**
     * DataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param HttpAlias $request
     * @param ScopeConfigInterface $scopeConfig
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        DataPersistorInterface $dataPersistor,
        HttpAlias $request,
        ScopeConfigInterface $scopeConfig,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
        $this->scopeConfig=$scopeConfig;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $comment) {
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

    /**
     * @return array
     */
    public function getMeta()
    {
        $meta = parent::getMeta();
        $id = $this->request->getParam('product_comments_id');
        if (!($id>0)) {
            $email = $this->scopeConfig->getValue('trans_email/ident_support/email', ScopeInterface::SCOPE_STORE);
            $name = $this->scopeConfig->getValue('trans_email/ident_support/name', ScopeInterface::SCOPE_STORE);

            $meta['general']['children']['email']['arguments']['data']['config']['value'] = $email;
            $meta['general']['children']['first_name']['arguments']['data']['config']['value'] = 'admin';
            $meta['general']['children']['last_name']['arguments']['data']['config']['value'] = $name;

            $meta['general']['children']['email']['arguments']['data']['config']['disabled'] = true;
            $meta['general']['children']['first_name']['arguments']['data']['config']['disabled'] = true;
            $meta['general']['children']['last_name']['arguments']['data']['config']['disabled'] = true;
        }
        return $meta;
    }
}
