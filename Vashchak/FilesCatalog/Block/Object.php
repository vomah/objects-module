<?php
namespace Vashchak\FilesCatalog\Block;

class Object extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Vashchak\FilesCatalog\Model\Object
     */
    protected $_objectFactory;

    /**
     * Object constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Vashchak\FilesCatalog\Model\Object              $objectFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Vashchak\FilesCatalog\Model\Object $objectFactory
    ) {
        $this->_objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * @return \Vashchak\FilesCatalog\Model\Object
     */
    public function getModel()
    {
        $model = $this->_objectFactory;

        if ($id = $this->getRequest()->getParam('id')) {
            $model->load($id);

            if (!$model->getId()) {
                throw new NotFoundException(__('Parameter is incorrect.'));
            }
        } else {
            throw new NotFoundException(__('Parameter is incorrect.'));
        }

        return $model;
    }

    public function getBreadCrumbs()
    {
        $model = $this->_objectFactory;
        $categories = $model->loadCategories();
        $this->setCategories();
    }

    /**
     * @return mixed
     */
    public function getObjectCollection()
    {
        $model = $this->_objectFactory;
        return $model->getCollection();
    }
}
