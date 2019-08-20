<?php
namespace Dev\ProductComments\Api;

use Dev\ProductComments\Api\Data\ItemInterface;

interface ItemRepositoryInterface
{
    /**
     * @param integer $productId
     * @return ItemInterface[]
     */
    public function getList($productId);
}
