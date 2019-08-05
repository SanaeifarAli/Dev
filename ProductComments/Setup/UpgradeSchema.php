<?php
namespace Dev\ProductComments\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Zend_Db_Exception;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     * @throws Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('product_comments')
            )->addColumn(
                'product_comments_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Product Comments Id'
            )->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Product Entity Id'
            )->addColumn(
                'first_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                15,
                ['nullable' => false],
                'First Name'
            )->addColumn(
                'last_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                20,
                ['nullable' => false],
                'Last Name'
            )->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                20,
                ['nullable' => false],
                'Email'
            )->addColumn(
                'comment',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '2M',
                ['nullable' => false],
                'Product Comment'
            )->addColumn(
                'comment_date',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                null,
                ['nullable' => false],
                'Comment Date'
            );
            $setup->getConnection()->createTable($table);
        }

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('product_comments'),
                'status',
                [
                    'type' => Table::TYPE_TEXT,
                    'size' => 12,
                    'nullable' => false,
                    'comment' => 'Approve Status'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('product_comments'),
                'status',
                'status',
                [
                    'type' => Table::TYPE_BOOLEAN,
                    'size' => null,
                    'default' => 0,
                    'nullable' => false,
                    'comment' => 'Approve Status'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('product_comments'),
                'created_at',
                [
                    'type' => Table::TYPE_TIMESTAMP,
                    'size' => null,
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT,
                    'comment' => 'Created At'
                ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('product_comments'),
                'created_at',
                [
                    'type' => Table::TYPE_TIMESTAMP,
                    'size' => null,
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT,
                    'comment' => 'Created At'
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $setup->getConnection()->dropColumn(
                $setup->getTable('product_comments'),
                'comment_date'
            );
        }

        $setup->endSetup();
    }
}
