<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel\Category;

/**
 * Class Collection
 * @package Vashchak\FilesCatalog\Model\ResourceModel\Category
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'vashchak_filescatalog_category_collection';
    protected $_eventObject = 'category_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            '\Vashchak\FilesCatalog\Model\Category',
            '\Vashchak\FilesCatalog\Model\ResourceModel\Category'
        );
    }
}
