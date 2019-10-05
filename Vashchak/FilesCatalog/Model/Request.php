<?php

namespace Vashchak\FilesCatalog\Model;

/**
 * Class Request
 * @package Vashchak\FilesCatalog\Model
 */
class Request extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'vashchak_filescatalog_request';

    protected $_cacheTag = 'vashchak_filescatalog_request';

    protected $_eventPrefix = 'vashchak_filescatalog_request';

    protected function _construct()
    {
        $this->_init('Vashchak\FilesCatalog\Model\ResourceModel\Request');
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
