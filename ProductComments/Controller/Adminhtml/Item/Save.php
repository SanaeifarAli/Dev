<?php
namespace Dev\ProductComments\Controller\Adminhtml\Item;

use Magento\Backend\App\Action\Context;
use Dev\ProductComments\Model\ItemFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;


class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var itemFactory
     */
    private $itemFactory;


      public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ItemFactory $itemFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->itemFactory = $itemFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            if (empty($data['product_comments_id'])) {
                $data['product_comments_id'] = null;
            }

            /** @var \Magento\Cms\Model\Block $model */

            $id = $this->getRequest()->getParam('product_comments_id');

            if ($id) {
                try {
                    $model = $this->itemFactory->create()->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This comment no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the comment.'));
                $this->dataPersistor->clear('product_comments');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['product_comments_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/index/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the comment.'));
            }

            $this->dataPersistor->set('product_comments', $data);
            return $resultRedirect->setPath('*/*/edit', ['product_comments_id' => $this->getRequest()->getParam('product_comments_id')]);
        }
        return $resultRedirect->setPath('*/index/index');
    }
}
