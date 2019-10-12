<?php
namespace Vashchak\FilesCatalog\Block;

use Magento\Framework\View\Element\Template;

class AbstractBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Vashchak\FilesCatalog\Model\ResourceModel\Object\Collection
     */
    protected $_mainFactory;

    /**
     * @var \Vashchak\FilesCatalog\Model\ResourceModel\ObjectCategory\Collection
     */
    protected $_objectCategoryFactory;

    /**
     * @var \Vashchak\FilesCatalog\Model\Object
     */
    protected $_model;

    /**
     * AbstractBlock constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->loadModel();
    }

    /**
     * load Objec Model
     */
    protected function loadModel()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $model = $this->getModelByCollection($this->_mainFactory, 'entity_id', $id);

            if ($model->isEmpty()) {
                throw new NotFoundException(__('Object not found.'));
            }

            $this->_model = $model;
        } else {
            throw new NotFoundException(__('Object not found.'));
        }
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param $factory
     * @param $field
     * @param $value
     * @param string $condition
     * @return \Magento\Framework\Model\AbstractModel
     */
    protected function getModelByCollection($factory, $field, $value, $condition = '=')
    {
        $objectCollection = $this->getCollection($factory, $field, $value, $condition);
        return $objectCollection->getFirstItem();
    }

    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $factory
     * @param $field
     * @param $value
     * @param string $condition
     * @return mixed
     */
    protected function getCollection($factory, $field, $value, $condition = '=')
    {
        $objectCollection = $factory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter(
                $field,
                [$condition => $value]
            );

        return $objectCollection;
    }
}
