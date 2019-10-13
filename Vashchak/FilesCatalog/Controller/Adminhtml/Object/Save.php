<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml\Object;

/**
 * Class Save
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Object
 */
class Save extends \Vashchak\FilesCatalog\Controller\Adminhtml\Object
{
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
}
