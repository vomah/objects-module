<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml\Object;

/**
 * Class Edit
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Object
 */
class Edit extends \Vashchak\FilesCatalog\Controller\Adminhtml\Object
{
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vashchak_FilesCatalog::save_object');
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
        $resultPage->setActiveMenu('Vashchak_FilesCatalog::object')
          ->addBreadcrumb(__('Objects'), __('Objects'))
          ->addBreadcrumb(__('Manage Objects'), __('Manage Objects'));
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
        $model = $this->_objectManager->create('Vashchak\FilesCatalog\Model\Object');

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
          $id ? __('Edit Object') : __('New Object'),
          $id ? __('Edit Object') : __('New Object')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Objects'));
        $resultPage->getConfig()->getTitle()
          ->prepend($model->getTitle() ? 'Edit object: ' . $model->getTitle() : __('New Object'));

        return $resultPage;
    }
}
