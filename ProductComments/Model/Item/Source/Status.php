<?php
namespace Dev\ProductComments\Model\Item\Source;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Not Approved',
                'value' => 0
            ],
            1 => [
                'label' => 'Approved',
                'value' => 1
            ]
        ];

        return $options;
    }
}
