<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel\Request;

/**
 * Class Collection
 * @package Vashchak\FilesCatalog\Model\ResourceModel\Request
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'request_id';
    protected $_eventPrefix = 'vashchak_filescatalog_collection';
    protected $_eventObject = 'request_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Vashchak\FilesCatalog\Model\Request', 'Vashchak\FilesCatalog\Model\ResourceModel\Request');
    }
}
