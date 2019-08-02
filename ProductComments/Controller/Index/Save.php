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
     * Save constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ItemFactory $itemFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        DataPersistorInterface $dataPersistor,
        ItemFactory $itemFactory
    ) {
        $this->itemFactory = $itemFactory;
        $this->dataPersistor = $dataPersistor;
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
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();

                return $resultRedirect;

            }catch(\Exception $e){
                $this->messageManager->addError($e->getMessage());

                $this->dataPersistor->set('product_comments', $this->getRequest()->getPostValue());

                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();
                return $resultRedirect;
            }
        }
    }
}