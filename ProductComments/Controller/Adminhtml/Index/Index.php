<?php
namespace Dev\ProductComments\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends Action
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $resultPage=$this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__("Product Comments"));
        return $resultPage;
    }
}
