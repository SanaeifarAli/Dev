<?php

namespace Dev\ProductComments\Controller\Index;

use Dev\ProductComments\Model\ItemFactory;
use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;

class Save extends Action
{

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var ItemFactory
     */
    private $itemFactory;

    /**
     * @var Http
     */
    protected $_request;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * Save constructor.
     *
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ItemFactory $itemFactory
     * @param Http $request
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ItemFactory $itemFactory,
        Http $request,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder
    ) {
        $this->itemFactory = $itemFactory;
        $this->dataPersistor = $dataPersistor;
        $this->_request = $request;
        $this->_storeManager = $storeManager;
        $this->_transportBuilder = $transportBuilder;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $post = (array) $this->getRequest()->getPost();
        if (!empty($post)) {
            try {
                $this->itemFactory->create()
                    ->setData($this->getRequest()->getPostValue())
                    ->save();
                $this->messageManager->addSuccessMessage('Your Comment Saved');
                $this->dataPersistor->clear('product_comments');
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();

                return $resultRedirect;
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                $this->dataPersistor->set('product_comments', $this->getRequest()->getPostValue());

                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();
                return $resultRedirect;
            }
        }
    }
}
