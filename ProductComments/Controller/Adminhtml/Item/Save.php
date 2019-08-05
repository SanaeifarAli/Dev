<?php
namespace Dev\ProductComments\Controller\Adminhtml\Item;

use Dev\ProductComments\Model\ItemFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $itemFactory;
    protected $dataPersistor;

    /**
     * Save constructor.
     *
     * @param Context        $context
     * @param PageFactory $resultPageFactory
     * @param ItemFactory     $itemFactory
     * @param DataPersistorInterface                     $dataPersistor
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ItemFactory $itemFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->itemFactory = $itemFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $id = $data['product_comments_id'];

                $comment = $this->itemFactory->create()->load($id);

                $data = array_filter(
                    $data,
                    function ($value) {
                        return $value !== '';
                    }
                );

                $comment->setData($data);
                $comment->save();
                $this->messageManager->addSuccessMessage(__('Successfully saved the item.'));
                $this->_objectManager->get(Session::class)->setFormData(false);
                $this->dataPersistor->clear('product_comments');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['product_comments_id' => $comment->getId(), '_current' => true]
                    );
                } else {
                    return $resultRedirect->setPath('*/index/index');
                }
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_objectManager->get(Session::class)->setFormData($data);
                $this->dataPersistor->set('product_comments', $data);
                return $resultRedirect->setPath('*/*/edit', ['product_comments_id' => $comment->getId()]);
            }
        }

        $this->dataPersistor->set('product_comments', $data);
        return $resultRedirect->setPath('*/index/index');
    }
}
