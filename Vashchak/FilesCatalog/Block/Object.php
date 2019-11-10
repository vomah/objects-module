<?php
namespace Vashchak\FilesCatalog\Block;

class Object extends AbstractBlock
{
    /**
     * @var \Vashchak\FilesCatalog\Model\ResourceModel\Category\Collection
     */
    protected $_categoryFactory;

    /**
     * @var string
     */
    protected $_categoryUrl;

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
        $this->_mainFactory = $objectFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_objectCategoryFactory = $objectCategoryFactory;
        $this->_categoryUrl = $context->getUrlBuilder()->getUrl('filescatalog/category/index');
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getCategoryUrl()
    {
        return $this->_categoryUrl;
    }

    /**
     * @return string
     */
    public function getBreadCrumbs()
    {
        $result = '';

        if ($categories = $this->loadCategories()) {
            if ($categoryId = $categories->getFirstItem()->getCategoryId()) {
                $category = $this->getModelByCollection($this->_categoryFactory, 'entity_id', $categoryId);
                $result = !$category->isEmpty() ? $category->getTitle() . ' > ' : '';
            }
        }

        $result .= $this->getModel()->getTitle();

        return $result;
    }

    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function loadCategories()
    {
        return $this->getObjectCategoryCollection();
    }

    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function getObjectCategoryCollection()
    {
        /** @var \Vashchak\FilesCatalog\Model\Object $model */
        $model = $this->getModel();

        $collection = [];
        if (($id = $model->getId()) && ($collection = $model->getCategories()) === null) {
            $collection = $this->getCollection($this->_objectCategoryFactory, 'object_id', $id);
            $model->setCategories($collection);
        }

        return $collection;
    }
}
