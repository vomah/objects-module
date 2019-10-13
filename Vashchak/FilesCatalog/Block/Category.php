<?php
namespace Vashchak\FilesCatalog\Block;

class Category extends AbstractBlock
{
    /**
     * @var \Vashchak\FilesCatalog\Model\ResourceModel\Object\Collection
     */
    protected $_objectFactory;

    /**
     * Object constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context                            $context
     * @param \Vashchak\FilesCatalog\Model\ResourceModel\Object\CollectionFactory         $objectFactory
     * @param \Vashchak\FilesCatalog\Model\ResourceModel\Category\CollectionFactory       $categoryFactory
     * @param \Vashchak\FilesCatalog\Model\ResourceModel\ObjectCategory\CollectionFactory $objectCategoryFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Vashchak\FilesCatalog\Model\ResourceModel\Object\CollectionFactory $objectFactory,
        \Vashchak\FilesCatalog\Model\ResourceModel\Category\CollectionFactory $categoryFactory,
        \Vashchak\FilesCatalog\Model\ResourceModel\ObjectCategory\CollectionFactory $objectCategoryFactory
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_mainFactory = $categoryFactory;
        $this->_objectCategoryFactory = $objectCategoryFactory;
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getBreadCrumbs()
    {
        $result = '';

        $result .= $this->getModel()->getTitle();

        return $result;
    }

    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function getObjects()
    {
        return $this->getObjectCategoryCollectionByCategory();
    }

    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function getObjectCategoryCollectionByCategory()
    {
        /** @var \Vashchak\FilesCatalog\Model\Category $model */
        $model = $this->getModel();
        $collection = $this->getObjectCollection($model->getId());
        $model->setObjects($collection);

        return $collection;
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function getObjectCollection($id)
    {
        $objectCollection = $this->_objectCategoryFactory->create();
        $objectCollection->addFieldToSelect('*');
        $objectCollection->getSelect()
            ->join(
                ['co' => 'vashchak_files_catalog_object'],
                'main_table.object_id = co.entity_id',
                []
            )
            ->columns('co.title')
            ->where('main_table.category_id = ' . $id);

        return $objectCollection;
    }
}
