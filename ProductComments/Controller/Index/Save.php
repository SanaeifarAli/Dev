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
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;

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
     * @var TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * Save constructor.
     *
     * @param Context $context
     * @param DataPersistorInterface                $dataPersistor
     * @param ItemFactory                           $itemFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ItemFactory $itemFactory,
        Http $request,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager
    ) {
        $this->itemFactory = $itemFactory;
        $this->dataPersistor = $dataPersistor;
        $this->_request = $request;
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
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
                $this->messageManager->addSuccessMessage('Your Comment Successfuly Saved');
                $this->dataPersistor->clear('product_comments');
                //---------SEND MAIL
                /*
                $store = $this->_storeManager->getStore()->getId();
                $transport = $this->_transportBuilder->setTemplateIdentifier('modulename_test_template')
                    ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
                    ->setTemplateVars(
                        [
                            'store' => $this->_storeManager->getStore(),
                        ]
                    )
                    ->setFrom(array('email' => 'b5b29ac3ac-f8d370@inbox.mailtrap.io', 'name' => 'SenderName'))
                    ->addTo('sanaeifara@yahoo.com', 'Customer Name')
                    ->getTransport();
                $transport->sendMessage();
                */
                //------------------
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();

                return $resultRedirect;
            } catch (Exception $e) {
                $this->messageManager->addError($e->getMessage());

                $this->dataPersistor->set('product_comments', $this->getRequest()->getPostValue());

                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();
                return $resultRedirect;
            }
        }
    }
}
