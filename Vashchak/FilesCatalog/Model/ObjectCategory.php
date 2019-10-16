<?php

namespace Vashchak\FilesCatalog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class ObjectCategory
 * @package Vashchak\FilesCatalog\Model
 */
class ObjectCategory extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'vashchak_filescatalog_object_category';

    protected $_cacheTag = 'vashchak_filescatalog_object_category';

    protected $_eventPrefix = 'vashchak_filescatalog_object_category';

    protected function _construct()
    {
        $this->_init('Vashchak\FilesCatalog\Model\ResourceModel\ObjectCategory');
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
        return [];
    }
}
