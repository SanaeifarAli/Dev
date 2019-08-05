<?php
namespace Dev\ProductComments\Controller\Adminhtml\Item;

use Dev\ProductComments\Model\ItemFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $itemFactory;

    /**
     * Delete constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ItemFactory $itemFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ItemFactory $itemFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->itemFactory = $itemFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('product_comments_id');

        $comment = $this->itemFactory->create()->load($id);

        if (!$comment) {
            $this->messageManager->addErrorMessage(__('Unable to process. please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/index/index', ['_current' => true]);
        }

        try {
            $comment->delete();
            $this->messageManager->addSuccessMessage(__('Your comment has been deleted !'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete comment'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/index/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/index/index', ['_current' => true]);
    }
}
