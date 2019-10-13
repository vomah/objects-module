<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml;

/**
 * Class Save
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Object
 */
class Object extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    protected $resultPageFactory;

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
        /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$model = $this->loadModel()) {
            return $resultRedirect->setPath('*/*/');
        }

        if (!$this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccess(__('You saved the Object.'));
        }

        $model->setTitle($this->getRequest()->getParam('title'));
        $model->setDescription($this->getRequest()->getParam('description'));
        $model->setKeywords($this->getRequest()->getParam('keywords'));
        $model->setStatus($this->getRequest()->getParam('status'));
        $model->save();

        $this->saveImages($model);

        $redirect = $resultRedirect->setPath(
            '*/*/edit',
            ['entity_id' => $model->getId(),
                '_current' => true]
        );
        return $redirect;
    }

    protected function saveImages($model)
    {

    }

    /**
     * @return \Vashchak\FilesCatalog\Model\Object
     */
    protected function loadModel()
    {
        /** @var \Vashchak\FilesCatalog\Model\Object $model */
        $model = $this->_objectManager->create('Vashchak\FilesCatalog\Model\Object');

        if ($id = $this->getRequest()->getParam('entity_id')) {
            $model->load($id);

            if (!$model->getId()) {
                $model = false;
                $this->messageManager->addError(__('This object no longer exists.'));
            }
        }

        return $model;
    }
}