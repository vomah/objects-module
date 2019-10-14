<?php

namespace Vashchak\FilesCatalog\Controller\Adminhtml\Object;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * @package Vashchak\FilesCatalog\Controller\Adminhtml\Object
 */
class Save extends \Vashchak\FilesCatalog\Controller\Adminhtml\Object
{
    const ADMIN_RESOURCE = 'Vashchak_FilesCatalog::helloworld';
    protected $imageUploader;


    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
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

        $this->saveImages();

        $redirect = $resultRedirect->setPath(
            '*/*/edit',
            ['entity_id' => $model->getId(),
                '_current' => true]
        );

        return $redirect;
    }

    protected function saveImages()
    {
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                $data['image'] = $data['image'][0]['name'];
                $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                    'QaisarSatti\HelloWorld\HelloWorldImageUpload'
                );
                $this->imageUploader->moveFileFromTmp($data['image']);
            } elseif (isset($data['image'][0]['image']) && !isset($data['image'][0]['tmp_name'])) {
                $data['image'] = $data['image'][0]['image'];
            } else {
                $data['image'] = null;
            }
        }

        return;
        $files = $this->getRequest()->getParam('image');
        if (!empty($_FILES)) {
            $fileUploaderFactory = $this->_objectManager->create(
                '\Magento\MediaStorage\Model\File\UploaderFactory'
            );

            $filesystem = $this->_objectManager->create(
                '\Magento\Framework\App\Filesystem\DirectoryList',
                ['root' => DirectoryList::MEDIA,]
            );

            $model = $this->getModel();

            $uploader = $fileUploaderFactory->create(['fileId' => 'image']);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);

            $path = $filesystem->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath('images/');

            $uploader->save($path);
        }
    }
}
