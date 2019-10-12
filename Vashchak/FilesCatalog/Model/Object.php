<?php

namespace Vashchak\FilesCatalog\Model;

/**
 * Class Object
 * @package Vashchak\FilesCatalog\Model
 */
class Object extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'vashchak_filescatalog_object';

    protected $_cacheTag = 'vashchak_filescatalog_object';

    protected $_eventPrefix = 'vashchak_filescatalog_object';

    protected function _construct()
    {
        $this->_init('Vashchak\FilesCatalog\Model\ResourceModel\Object');
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
     * @param $categories
     */
    public function setCategories($categories)
    {
        $this->setData('categories', $categories);
    }

    /**
     * @return array|mixed
     */
    public function getCategories()
    {
        return $this->getData('categories');
    }
}
