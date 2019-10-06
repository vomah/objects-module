<?php

namespace Vashchak\FilesCatalog\Setup;

/**
 * Class InstallSchema
 * @package Vashchak\FilesCatalog\Setup
 */
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface   $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    public function install(
      \Magento\Framework\Setup\SchemaSetupInterface $setup,
      \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        $this->createObjectTable($installer);
        $this->createCategoryTable($installer);
        $this->createObjectCategoryTable($installer);
        $this->createObjectMediaTable($installer);

        $installer->endSetup();
    }

    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $installer
     */
    protected function createObjectTable(\Magento\Framework\Setup\SchemaSetupInterface $installer)
    {
        if (!$installer->tableExists('vashchak_files_catalog_object')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('vashchak_files_catalog_object')
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Object Id'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    1,
                    [],
                    'Status'
                )
                ->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Title'
                )
                ->addColumn(
                    'description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false],
                    'Description'
                )
                ->addColumn(
                    'keywords',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Keywords'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At')
                ->setComment('Object Table');

            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('vashchak_files_catalog_object'),
                $installer->getIdxName(
                    $installer->getTable('vashchak_files_catalog_object'),
                    ['title', 'description', 'keywords'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title', 'description', 'keywords'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
    }

    protected function createCategoryTable(\Magento\Framework\Setup\SchemaSetupInterface $installer)
    {
        if (!$installer->tableExists('vashchak_files_catalog_category')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('vashchak_files_catalog_category')
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Category Id'
                )
                ->addColumn(
                    'parent_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [],
                    'Parent Category Id'
                )
                ->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Title'
                )
                ->setComment('Category Table');

            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('vashchak_files_catalog_category'),
                $installer->getIdxName(
                    $installer->getTable('vashchak_files_catalog_category'),
                    ['title',],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['title',],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );
        }
    }

    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $installer
     */
    protected function createObjectCategoryTable(\Magento\Framework\Setup\SchemaSetupInterface $installer)
    {
        if (!$installer->tableExists('vashchak_files_catalog_object_category')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('vashchak_files_catalog_object_category')
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Object Id'
                )
                ->addColumn(
                    'category_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [],
                    'Category Id'
                )
                ->addColumn(
                    'object_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [],
                    'Object Id'
                )
                ->addColumn(
                    'sort_order',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [],
                    'Sort Order'
                )
                ->setComment('Object To Category Linkage Table');

            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('vashchak_files_catalog_object_category'),
                $installer->getIdxName(
                    $installer->getTable('vashchak_files_catalog_object_category'),
                    ['entity_id', 'category_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'category_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );
        }
    }

    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $installer
     */
    protected function createObjectMediaTable(\Magento\Framework\Setup\SchemaSetupInterface $installer)
    {
        if (!$installer->tableExists('vashchak_files_catalog_object_media')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('vashchak_files_catalog_object_media')
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Media Entity Id'
                )
                ->addColumn(
                    'object_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [],
                    'Related to Object Id'
                )
                ->addColumn(
                    'media_type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    10,
                    [],
                    'Media Typw'
                )
                ->addColumn(
                    'label',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    10,
                    [],
                    'Media Label'
                )
                ->addColumn(
                    'file_path',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    10,
                    [],
                    'File Path'
                )
                ->setComment('Object Media');

            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('vashchak_files_catalog_object_media'),
                $installer->getIdxName(
                    $installer->getTable('vashchak_files_catalog_object_media'),
                    ['entity_id', 'object_id', 'file_path'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['entity_id', 'object_id', 'file_path'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
            );
        }
    }
}
