<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml\Object;

/**
 * Class Save
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Object
 */
class Save extends \Magento\Framework\App\Action\Action
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

        $status = $this->getRequest()->getParam('status');

        $redirect = $resultRedirect->setPath('*/*/');

        if ($this->getRequest()->getParam('back')) {

            if ($this->sendEmailResponse($model)) {
                $status = 1;
            }

            $redirect = $resultRedirect->setPath(
              '*/*/edit',
              ['entity_id' => $model->getId(),
               '_current' => true]
            );
        } else {
            $this->messageManager->addSuccess(__('You saved the Object.'));
        }

        $model->setStatus($status);
        $model->save();

        $redirect = $resultRedirect->setPath(
          '*/*/edit',
          ['entity_id' => $model->getId(),
           '_current' => true]
        );
        return $redirect;
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

    /**
     * @param \Vashchak\FilesCatalog\Model\Object $model
     */
    protected function sendEmailResponse($model)
    {
        try {
            $result = false;

            if ($response = $this->getRequest()->getParam('reply')) {
                $clientEmail = $model->getEmail();
                $clientName = $model->getName();

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $reportSend = $objectManager->create('Vashchak\FilesCatalog\Model\ResponseSend');
                $reportSend->execute($clientEmail, $clientName, $response);

                $result = true;
                $this->messageManager->addSuccessMessage(__('Reply to client object was send.'));
            } else {
                $this->messageManager->addErrorMessage(__('Fill the reply field please.'));
            }
        } catch (\Throwable $exception) {
            $result = false;
            $this->messageManager->addErrorMessage(__($exception->getMessage()));
        }

        return $result;
    }
}
