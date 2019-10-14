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

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        $this->loadedData = [];
        /** @var Object $customer */
        foreach ($items as $object) {
            $this->loadedData[$object->getId()]['title'] = $object->getTitle();
            $this->loadedData[$object->getId()]['files'] = '';
        }


        return $this->loadedData;
    }
}
