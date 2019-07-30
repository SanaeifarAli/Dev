<?php
namespace Dev\ProductComments\Controller\Adminhtml\Item;

class Save extends \Magento\Backend\App\Action
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
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if($data)
        {
            try {
                $id = $data['product_comments_id'];

                $comment = $this->itemFactory->create()->load($id);

                $data = array_filter($data, function ($value) {
                    return $value !== '';
                });

                $comment->setData($data);
                $comment->save();
                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['product_comments_id' => $comment->getId(), '_current' => true]);
                }
                else{
                    return $resultRedirect->setPath('*/index/index');
                }
            }
            catch(\Exception $d)
            {
                $this->messageManager->addError($d->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['product_comments_id' => $comment->getId()]);
            }
        }



        //if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['product_comments_id' => $comment->getId(), '_current' => true]);
        //}
        //else{
        //    return $resultRedirect->setPath('*/index/index');
        //}

        //return $resultRedirect->setPath('*/index/index');
    }
}