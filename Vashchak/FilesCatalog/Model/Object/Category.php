<?php

namespace Vashchak\FilesCatalog\Model\Object;

use Magento\Framework\App\ObjectManager;
use Vashchak\FilesCatalog\Model\ResourceModel\Category\Collection;

class Category implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Retrieve options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return self::getOptionArray();
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        $categoryCollection = self::getCategoryCollection();
        return $categoryCollection->toOptionArray();
    }

    /**
     * @return Collection
     */
    protected static function getCategoryCollection()
    {
        $category = ObjectManager::getInstance()->get('\Vashchak\FilesCatalog\Model\ResourceModel\Category\CollectionFactory');

        $collection = $category->create()
            ->addFieldToSelect('*');

        return $collection;
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        return self::getOptionArray();
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();
        return $options[$optionId]['label'] ?? null;
    }
}