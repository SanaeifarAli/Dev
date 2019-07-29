<?php
namespace Dev\ProductComments\Controller\Adminhtml\Item;

use Dev\ProductComments\Model\Item as Comment;


class Delete extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $itemFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Dev\ProductComments\Model\ItemFactory $itemFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->itemFactory = $itemFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        $comment = $this->itemFactory->create()->load($id);

        if(!$comment)
        {
            $this->messageManager->addError(__('Unable to process. please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/index/index', array('_current' => true));
        }

        try{
            $comment->delete();
            $this->messageManager->addSuccess(__('Your comment has been deleted !'));
        }
        catch(\Exception $e)
        {
            $this->messageManager->addError(__('Error while trying to delete comment'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/index/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/index/index', array('_current' => true));
    }
}
