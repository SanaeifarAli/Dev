<?php

namespace Dev\ProductComments\Model\Item\Source;

class Products implements \Magento\Framework\Option\ArrayInterface
{
    protected $productCollection;
    protected $productRepository;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) {
        $this->productCollection = $productCollection;
        $this->productRepository = $productRepository;
    }

    public function toOptionArray()
    {

        $products = $this->productCollection->load();
        $options = [];

        /* @todo: add query to load selected options */

        foreach ($products as $product){


            $productId = $product->getId();
            $productName = $this->productRepository->getById($productId)->getName();

            $options[] = [
                "value" => $productId,
                "label" => $productName
            ];
        }

        return $options;
    }
}