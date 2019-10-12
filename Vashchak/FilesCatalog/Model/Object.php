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
     * @return array|mixed
     */
    public function loadCategories()
    {
        if (($categories = $this->getCategories()) === null) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            /** @var \Vashchak\FilesCatalog\Model\ObjectCategory $model */
            $model = $objectManager->create('Vashchak\FilesCatalog\Model\ObjectCategory');

            $categories = [];
            if ($id = $this->getId()) {
                $model->beforeLoad($id, 'object_id');
                $collection = $model->getCollection();

                foreach ($collection as $category) {
                    $categories[$category->getCategoryId()] = $category;
                }
            }

            $this->setCategories($categories);
        }

        $this->setCategories($categories);
        return $categories;
    }

    /**
     * @param $categories
     */
    protected function setCategories($categories)
    {
        $this->setData('categories', $categories);
    }

    /**
     * @return array|mixed
     */
    public function getCategories()
    {
        if (($categories = $this->getData('categories')) === null) {
            $categories = $this->loadCategories();
        }

        return $categories;
    }
}
