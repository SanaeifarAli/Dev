<?php
namespace Dev\ProductComments\Model\Attribute\Backend;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;

class Material extends AbstractBackend
{
    /**
     * Validate
     *
     * @param  Product $object
     * @return bool
     * @throws LocalizedException
     */
    public function validate($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if (($object->getAttributeSetId() == 10) && ($value == 'yes')) {
            throw new LocalizedException(
                __('Bottom can not be yes.')
            );
        }
        return true;
    }
}
