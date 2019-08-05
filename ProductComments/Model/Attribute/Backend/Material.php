<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dev\ProductComments\Model\Attribute\Backend;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;

class Material extends AbstractBackend
{
    /**
     * Validate
     * @param Product $object
     * @return bool
     */
    public function validate($object)
    {
        return true;
    }
}
