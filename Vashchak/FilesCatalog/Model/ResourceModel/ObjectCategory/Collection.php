<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel\ObjectCategory;

/**
 * Class Collection
 * @package Vashchak\FilesCatalog\Model\ResourceModel\ObjectCategory
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'vashchak_filescatalog_collection';
    protected $_eventObject = 'object_category_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            '\Vashchak\FilesCatalog\Model\ObjectCategory',
            '\Vashchak\FilesCatalog\Model\ResourceModel\ObjectCategory'
        );
    }
}
