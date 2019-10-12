<?php
namespace Vashchak\FilesCatalog\Controller\Category;

class Index extends \Magento\Framework\App\Action\Action
{
  /**
   * @var \Magento\Framework\View\Result\PageFactory
   */
  protected $_pageFactory;

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
    $this->_pageFactory = $resultPageFactory;
  }

  /**
   * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
   */
  public function execute()
  {
    return $this->_pageFactory->create();
  }
}
