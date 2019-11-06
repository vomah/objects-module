<?php
namespace Vashchak\FilesCatalog\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $this->_updateCategoryTable($setup);
        }

        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    protected function _updateCategoryTable($setup)
    {
        $tableName = $setup->getTable('vashchak_files_catalog_category');

        // Check if the table already exists
        if ($setup->getConnection()->isTableExists($tableName) == true) {
            // Declare data
            $columns = [
                'path' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'size' => 255,
                    'nullable' => false,
                    'comment' => 'Tree Path',
                ],
                'position' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'size' => 11,
                    'nullable' => false,
                    'comment' => 'Position',
                ],
                'level' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'size' => 11,
                    'default' => 0,
                    'nullable' => false,
                    'comment' => 'Tree Level',
                ],
                'children_count' => [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'size' => 11,
                    'nullable' => false,
                    'comment' => 'Child Count',
                ],
            ];

            $connection = $setup->getConnection();
            foreach ($columns as $name => $definition) {
                $connection->addColumn($tableName, $name, $definition);
            }

            $newIndexes = [
                'path',
                'level',
            ];

            foreach ($newIndexes as $item) {
                $connection->addIndex(
                    $setup->getTable('vashchak_files_catalog_category'),
                    $setup->getIdxName(
                        $setup->getTable('vashchak_files_catalog_category'),
                        [$item],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                    ),
                    [$item]
                );
            }
        }
    }
}
