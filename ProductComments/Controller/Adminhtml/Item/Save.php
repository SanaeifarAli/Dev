<?php
namespace Dev\ProductComments\Controller\Adminhtml\Item;

use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $itemFactory;
    protected $dataPersistor;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Dev\ProductComments\Model\ItemFactory $itemFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Dev\ProductComments\Model\ItemFactory $itemFactory,
        DataPersistorInterface $dataPersistor
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->itemFactory = $itemFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
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
                $this->dataPersistor->clear('product_comments');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['product_comments_id' => $comment->getId(), '_current' => true]);
                }
                else{
                    return $resultRedirect->setPath('*/index/index');
                }
            }
            catch(\Exception $e)
            {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                $this->dataPersistor->set('product_comments', $data);
                return $resultRedirect->setPath('*/*/edit', ['product_comments_id' => $comment->getId()]);
            }
        }

        $this->dataPersistor->set('product_comments', $data);
        return $resultRedirect->setPath('*/index/index');
    }
}