<?php

namespace Vashchak\FilesCatalog\Model\Object;

use Vashchak\FilesCatalog\Model\ResourceModel\Object\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $this->prepareCollection();
        $items = $this->collection->getItems();

        $this->loadedData = [];
        /** @var Object $object */
        foreach ($items as $object) {
            $id = $object->getId();
            $this->loadedData[$id]['object']['entity_id'] = $id;
            $this->loadedData[$id]['object']['status'] = $object->getStatus();
            $this->loadedData[$id]['object']['title'] = $object->getTitle();
            $this->loadedData[$id]['object']['description'] = $object->getDescription();
            $this->loadedData[$id]['object']['keywords'] = $object->getKeywords();
            $this->loadedData[$id]['object']['category'] = $object->getCategoryId();
            $this->loadedData[$id]['object']['files'] = '';
        }


        return $this->loadedData;
    }

    /**
     * Add category
     */
    protected function prepareCollection()
    {
        $select = $this->collection->getSelect()->getPart('where');
        foreach ($select as &$item) {
            $item = preg_replace('/`(entity_id)`/', 'main_table.$1', $item);
        }

        $this->collection->getSelect()
            ->joinLeft(
                ['coc' => 'vashchak_files_catalog_object_category'],
                'main_table.entity_id = coc.object_id',
                ['coc.category_id']
            )
            ->reset('where')
            ->where(reset($select));
    }
}
