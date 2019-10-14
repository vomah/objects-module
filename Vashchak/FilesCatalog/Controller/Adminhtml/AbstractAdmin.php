<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml;

/**
 * Class Save
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\AbstractAdmin
 */
class AbstractAdmin extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var string
     */
    protected $_collectionFactoryName;

    /**
     * @var \Vashchak\FilesCatalog\Model\Object
     */
    protected $_model;

    /**
     * Save constructor.
     *
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Save
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {

    }

    /**
     * @return \Magento\Framework\Model\AbstractModel
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @return \Vashchak\FilesCatalog\Model\Object|bool
     */
    protected function loadModel()
    {
        $model = false;

        if ($id = $this->getRequest()->getParam('entity_id')) {
            $collection = $this->_objectManager->create($this->_collectionFactoryName);

            $model = $this->getModelByCollection($collection, 'entity_id', $id);

            if ($model->isEmpty()) {
                $model = false;
                $this->messageManager->addError(__('This object no longer exists.'));
            }

            $this->_model = $model;
        }

        return $model;
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
