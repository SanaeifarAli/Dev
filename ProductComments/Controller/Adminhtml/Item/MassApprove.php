<?php

namespace Dev\ProductComments\Controller\Adminhtml\Item;

use Dev\ProductComments\Model\Item;

class MassApprove extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
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
                $comment->setStatus(1);
                $comment->save();
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been approved.', count($ids)));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/index/index', ['_current' => true]);
    }
}
