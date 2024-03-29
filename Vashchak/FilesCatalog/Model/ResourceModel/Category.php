<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel;

/**
 * Class Category
 * @package Vashchak\FilesCatalog\Model\ResourceModel
 */
class Category extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Category constructor.
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
        $this->_init('vashchak_files_catalog_category', 'entity_id');
    }
}
