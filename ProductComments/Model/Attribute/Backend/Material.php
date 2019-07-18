<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dev\ProductComments\Model\Attribute\Backend;

class Material extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * Validate
     * @param \Magento\Catalog\Model\Product $object
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validate($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if (($object->getAttributeSetId() == 10) && ($value == 'yes')) {
            throw new \Magento\Framework\Exception\LocalizedException(
               __('Bottom can not be yes.')
            );
        }
        return true;
    }
}
