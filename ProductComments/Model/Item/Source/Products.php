<?php
namespace Dev\ProductComments\Model\Item\Source;

use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Option\ArrayInterface;

class Products implements ArrayInterface
{
    protected $productCollection;

    /**
     * Products constructor.
     *
     * @param Collection $productCollection
     * @param ProductRepository                $productRepository
     */
    public function __construct(
        Collection $productCollection
    ) {
        $this->productCollection = $productCollection;
    }

    /**
     * @return array
     * @throws NoSuchEntityException
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
