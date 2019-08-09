<?php
namespace Dev\ProductComments\Api;

interface ItemRepositoryInterface
{
    /**
     * @param integer $productId
     * @return \Dev\ProductComments\Api\Data\ItemInterface[]
     */
    public function getList($productId);
}
