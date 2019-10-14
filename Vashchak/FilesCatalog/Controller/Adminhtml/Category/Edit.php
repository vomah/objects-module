<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml\Category;

/**
 * Class Edit
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Category
 */
class Edit extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    protected $resultPageFactory;

    /**
     * Edit constructor.
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
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vashchak_FilesCatalog::save_category');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vashchak_FilesCatalog::category')
          ->addBreadcrumb(__('category'), __('Category'))
          ->addBreadcrumb(__('Manage category'), __('Manage category'));
        return $resultPage;
    }

    /**
     * Edit
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        /** @var \Vashchak\FilesCatalog\Model\Object $model */
        $model = $this->_objectManager->create('Vashchak\FilesCatalog\Model\Category');

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addError(__('This object no longer exists.'));

                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
          $id ? __('Edit Category') : __('New Category'),
          $id ? __('Edit Category') : __('New Category')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Category'));
        $resultPage->getConfig()->getTitle()
          ->prepend($model->getId() ? 'Edit category: ' . $model->getId() : __('New Category'));

        return $resultPage;
    }
}
