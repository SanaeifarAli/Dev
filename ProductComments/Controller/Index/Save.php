<?php

namespace Dev\ProductComments\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Dev\ProductComments\Model\ItemFactory;

class Save extends \Magento\Framework\App\Action\Action
{
    private $itemFactory;

    /**
     * Save constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param ItemFactory $itemFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        ItemFactory $itemFactory
    ) {
        $this->itemFactory = $itemFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $post = (array) $this->getRequest()->getPost();

        if (!empty($post)) {
            //$entity_id   = $post['entity_id'];
            //$first_name   = $post['first_name'];
            //$last_name   = $post['last_name'];
            //$email   = $post['email'];
            //$comment   = $post['comment'];
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $objDate = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
            $_POST['comment_date'] ='2019/01/01 19:23:00'; //$objDate->gmtDate();

            $this->itemFactory->create()
                ->setData($this->getRequest()->getPostValue())
                ->save();
            $this->messageManager->addSuccessMessage('Your Comment Is Successfuly Saved!!!!!');

            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();

            return $resultRedirect;
            //return $this->resultRedirectFactory->create()->setPath('/');
        }
    }
}