<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml\Object;

use Magento\Backend\Model\Session;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Vashchak\FilesCatalog\Controller\Adminhtml\Object;
use Vashchak\FilesCatalog\Model\ResourceModel\ObjectCategory\Collection;
use Vashchak\FilesCatalog\Model\Uploader;
use Vashchak\FilesCatalog\Model\UploaderPool;

/**
 * Class Save
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Object
 */
class Save extends Object
{
    /**
     * @var
     */
    protected $imageUploader;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     * @param UploaderPool $uploaderPool
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        UploaderPool $uploaderPool
    ) {
        $this->uploaderPool = $uploaderPool;
        parent::__construct($context, $resultPageFactory);
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

        $data = $this->getRequest()->getPostValue();
        if (!($data = $data['object'] ?? []) || !$model = $this->loadModel($data['entity_id'])) {
            return $resultRedirect->setPath('*/*/');
        }

        if (!$this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccess(__('You saved the Object.'));
        }

        try {
            $this->saveObject($model, $data);
            $this->saveCategory($model->getId(), $data['category']);
            $this->saveImages($data);
        } catch (\Throwable $e) {}

        $redirect = $resultRedirect->setPath(
            '*/*/edit',
            ['entity_id' => $model->getId(),
                '_current' => true]
        );

        return $redirect;
    }

    /**
     * @param \Vashchak\FilesCatalog\Model\Object $model
     * @param array $data
     *
     * @throws \Throwable
     */
    protected function saveObject($model, $data)
    {
        $model->setTitle($data['title']);
        $model->setDescription($data['description']);
        $model->setKeywords($data['keywords']);
        $model->setStatus($data['status']);
        $model->save();
    }

    /**
     * @param $objectId
     * @param $categoryId
     */
    protected function saveCategory($objectId, $categoryId)
    {
        /** @var Collection $objectCategoryCollection */
        $objectCategoryCollection = $this->getCollection(
            $this->_objectManager->create($this->_objectCategoryCollectionFactoryName),
            'object_id',
            $objectId
        );

        $objectCategoryItem = $objectCategoryCollection->getFirstItem();
        if ($objectCategoryItem->getCategoryId() !== $categoryId) {
            $objectCategoryItem->setCategoryId($categoryId);
            $objectCategoryCollection->save();
        }
    }

    /**
     * @param array $data
     */
    protected function saveImages($data)
    {
        $avatar = $this->getUploader('images')->uploadFileAndGetName('images', $data);
        $resume = $this->getUploader('files')->uploadFileAndGetName('files', $data);
    }

    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
}
