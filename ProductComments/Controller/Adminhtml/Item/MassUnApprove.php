<?php

namespace Dev\ProductComments\Controller\Adminhtml\Item;

use Dev\ProductComments\Model\Item;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class MassUnApprove extends Action
{
    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected', []);
        if (!is_array($ids) || !count($ids)) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/index/index', ['_current' => true]);
        }
        foreach ($ids as $id) {
            if ($comment = $this->_objectManager->create(Item::class)->load($id)) {
                $comment->setStatus(0);
                $comment->save();
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been unapproved.', count($ids)));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/index/index', ['_current' => true]);
    }
}
