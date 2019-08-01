<?php

namespace Dev\ProductComments\Controller\Adminhtml\Item;

use Magento\Backend\App\Action;
use Dev\ProductComments\Model\Item;

class MassUnApprove extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected', []);
        if (!is_array($ids) || !count($ids)) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/index/index', array('_current' => true));
        }
        foreach ($ids as $id) {
            if ($comment = $this->_objectManager->create(Item::class)->load($id)) {
                $comment->setStatus(0);
                $comment->save();
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been unapproved.', count($ids)));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/index/index', array('_current' => true));
    }
}