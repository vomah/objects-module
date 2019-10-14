<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel;

/**
 * Class Media
 * @package Vashchak\FilesCatalog\Model\ResourceModel
 */
class Media extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Media constructor.
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
        $this->_init('vashchak_files_catalog_object_media', 'entity_id');
    }
}
