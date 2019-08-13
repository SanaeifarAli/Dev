<?php
namespace Dev\ProductComments\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Message\ManagerInterface;

class CustomerCommentSuccess implements ObserverInterface
{
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * CustomerCommentSuccess constructor.
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        ManagerInterface $messageManager
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->messageManager = $messageManager;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $post = $observer->getEvent();
        $receiverName = $post->getData('first_name').' '.$post->getData('last_name');
        $receiverEmail = $post->getData('last_name');
        $comment = $post->getData('comment');
        $store = $this->storeManager->getStore();
        $templateParams = ['store' => $store, 'comment' => $comment, 'administrator_name' => $receiverName];
        $transport = $this->transportBuilder->setTemplateIdentifier(
            'product_comments_email_template'
        )->setTemplateOptions(
            ['area' => 'frontend', 'store' => $store->getId()]
        )->addTo(
            $receiverEmail,
            $receiverName
        )->setTemplateVars(
            $templateParams
        )->setFrom(
            'general'
        )->getTransport();
        try {
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this;
    }
}
