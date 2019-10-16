<?php

namespace Vashchak\FilesCatalog\Model\ResourceModel\Category;

/**
 * Class Collection
 * @package Vashchak\FilesCatalog\Model\ResourceModel\Category
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'vashchak_filescatalog_category_collection';
    protected $_eventObject = 'category_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            '\Vashchak\FilesCatalog\Model\Category',
            '\Vashchak\FilesCatalog\Model\ResourceModel\Category'
        );
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            ['value' => 0, 'label' => 'Root'],
        ];

        foreach ($this->getItems() as $item) {
            $id = $item->getId();
            $options[$id] = ['value' => $id, 'label' => $item->getTitle()];
        }

        return $options;
    }
}
