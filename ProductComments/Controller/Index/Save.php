<?php

namespace Dev\ProductComments\Controller\Index;

use Dev\ProductComments\Model\ItemFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Framework\App\Action\Action
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
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * Save constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param DataPersistorInterface                $dataPersistor
     * @param ItemFactory                           $itemFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        DataPersistorInterface $dataPersistor,
        ItemFactory $itemFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->itemFactory = $itemFactory;
        $this->dataPersistor = $dataPersistor;
        $this->_request = $request;
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
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
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                $this->dataPersistor->set('product_comments', $this->getRequest()->getPostValue());

                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();
                return $resultRedirect;
            }
        }
    }
}
