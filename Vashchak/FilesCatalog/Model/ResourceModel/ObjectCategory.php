<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel;

/**
 * Class ObjectCategory
 * @package Vashchak\FilesCatalog\Model\ResourceModel
 */
class ObjectCategory extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * ObjectCategory constructor.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('vashchak_files_catalog_object_category', 'entity_id');
    }
}
