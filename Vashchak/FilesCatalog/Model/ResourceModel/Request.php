<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel;

/**
 * Class Request
 * @package Vashchak\FilesCatalog\Model\ResourceModel
 */
class Request extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Request constructor.
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
        $this->_init('vashchak_files_catalog', 'request_id');
    }
}
