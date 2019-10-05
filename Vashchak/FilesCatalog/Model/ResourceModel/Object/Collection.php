<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel\Object;

/**
 * Class Collection
 * @package Vashchak\FilesCatalog\Model\ResourceModel\Object
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'vashchak_filescatalog_collection';
    protected $_eventObject = 'object_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Vashchak\FilesCatalog\Model\Object',
            'Vashchak\FilesCatalog\Model\ResourceModel\Object'
        );
    }
}
