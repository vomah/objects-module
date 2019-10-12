<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml\Category;

/**
 * Class Index
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Category
 */
class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    /**
     * Index constructor.
     *
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
      \Magento\Backend\App\Action\Context $context,
      \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vashchak_FilesCatalog::object');
        $resultPage->getConfig()->getTitle()->prepend((__('Objects')));

        return $resultPage;
    }
}
