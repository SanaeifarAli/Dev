<?php

namespace Dev\ProductComments\Ui\Component\Grid\Column;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ColumnRender extends Column
{
    protected $escaper;

    protected $systemStore;
    protected $productRepositoryInterface;

    /**
     * ColumnRender constructor.
     *
     * @param ContextInterface                                $context
     * @param UiComponentFactory                              $uiComponentFactory
     * @param ProductRepositoryInterface                      $productRepositoryInterface
     * @param Escaper                                         $escaper
     * @param array                                           $components
     * @param array                                           $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ProductRepositoryInterface $productRepositoryInterface,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        $this->escaper = $escaper;
        $this->productRepositoryInterface = $productRepositoryInterface;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as $key => $items) {
                $product = $this->productRepositoryInterface->getById($items["entity_id"]);
                $dataSource['data']['items'][$key]['entity_id'] = $product->getName();

                if ($items["status"]) {
                    $dataSource['data']['items'][$key]['status'] = 'Approved';
                } else {
                    $dataSource['data']['items'][$key]['status'] = 'Not Approved';
                }
            }
        }

        return $dataSource;
    }
}
