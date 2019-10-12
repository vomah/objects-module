<?php

namespace Vashchak\FilesCatalog\Model;

/**
 * Class Category
 * @package Vashchak\FilesCatalog\Model
 */
class Category extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'vashchak_filescatalog_category';

    protected $_cacheTag = 'vashchak_filescatalog_category';

    protected $_eventPrefix = 'vashchak_filescatalog_category';

    protected function _construct()
    {
        $this->_init('Vashchak\FilesCatalog\Model\ResourceModel\Category');
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

    /**
     * @param $objects
     */
    public function setObjects($objects)
    {
        $this->setData('objects', $objects);
    }

    /**
     * @return array|mixed
     */
    public function getObjects()
    {
        return $this->getData('objects');
    }
}
