<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml;

/**
 * Class Save
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\AbstractAdmin
 */
class Object extends AbstractAdmin
{
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
        parent::__construct($context, $resultPageFactory);
        $this->_collectionFactoryName = '\Vashchak\FilesCatalog\Model\ResourceModel\Object\CollectionFactory';
    }
}
