<?php
namespace Dev\ProductComments\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup,ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()->newTable(
            $installer->getTable('product_comments')
        )->addColumn(
            'product_comments_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary'
            => true],
            'Product Comments Id'
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
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}