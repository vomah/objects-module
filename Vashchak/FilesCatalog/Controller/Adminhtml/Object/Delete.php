<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml\Object;

/**
 * Class Delete
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Object
 */
class Delete extends \Vashchak\FilesCatalog\Controller\Adminhtml\Object
{
    /**
     * Save
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        if ($model = $this->loadModel()) {
            $model->delete();
        }

        /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
