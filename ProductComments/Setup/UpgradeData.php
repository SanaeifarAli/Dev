<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dev\ProductComments\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function Upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(),'1.0.0','<')){

            $table = $setup->getConnection()->insert(
                $setup->getTable('product_comments'),
                [
                    'entity_id' => 'Item 1',
                    'first_name' => 'Item 1',
                    'last_name' => 'Item 1',
                    'email' => 'Item 1',
                    'comment' => 'Item 1'

                ]
            );

        }
        $setup->endSetup();
    }
}
