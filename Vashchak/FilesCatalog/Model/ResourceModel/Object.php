<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel;

/**
 * Class Object
 * @package Vashchak\FilesCatalog\Model\ResourceModel
 */
class Object extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Object constructor.
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
        $this->_init('vashchak_files_catalog_object', 'entity_id');
    }
}
