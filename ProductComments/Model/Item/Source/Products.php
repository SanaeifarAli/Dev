<?php
namespace Dev\ProductComments\Model\Item\Source;

class Products implements \Magento\Framework\Option\ArrayInterface
{
    protected $productCollection;

    /**
     * Products constructor.
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @param \Magento\Catalog\Model\ProductRepository                $productRepository
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
    ) {
        $this->productCollection = $productCollection;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function toOptionArray()
    {
        $products = $this->productCollection->addAttributeToSelect(['*']);
        $options = [];

        /* @todo: add query to load selected options */

        foreach ($products as $product) {
            $productId = $product->getId();
            $productName = $product->getName();

            $options[] = [
                "value" => $productId,
                "label" => $productName
            ];
        }

        return $options;
    }
}
