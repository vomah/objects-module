<?php

namespace Vashchak\FilesCatalog\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * Class Object
 * @package Vashchak\FilesCatalog\Model
 */
class Object extends AbstractModel implements IdentityInterface
{
    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    const CACHE_TAG = 'vashchak_filescatalog_object';

    protected $_cacheTag = 'vashchak_filescatalog_object';

    protected $_eventPrefix = 'vashchak_filescatalog_object';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param UploaderPool $uploaderPool
     * @param array $data
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     */
    public function __construct(
        Context $context,
        Registry $registry,
        UploaderPool $uploaderPool,
        array $data = [],
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null
    ) {
        $this->uploaderPool = $uploaderPool;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Vashchak\FilesCatalog\Model\ResourceModel\Object');
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        return [];
    }

    /**
     * @param $categories
     */
    public function setCategories($categories)
    {
        $this->setData('categories', $categories);
    }

    /**
     * @return array|mixed
     */
    public function getCategories()
    {
        return $this->getData('categories');
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getImages()
    {
        return $this->getData('images');
    }

    /**
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImagesUrl()
    {
        $url = false;
        $images = $this->getImages();

        if ($images) {
            if (is_string($images)) {
                $uploader = $this->uploaderPool->getUploader('images');
                $url = $uploader->getBaseUrl() . $uploader->getBasePath() . $images;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the images url.')
                );
            }
        }

        return $url;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getFiles()
    {
        return $this->getData('files');
    }

    /**
     * @return bool|string
     * @throws LocalizedException
     */
    public function getFilesUrl()
    {
        $url = false;
        $files = $this->getFiles();

        if ($files) {
            if (is_string($files)) {
                $uploader = $this->uploaderPool->getUploader('files');
                $url = $uploader->getBaseUrl() . $uploader->getBasePath() . $files;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the files url.')
                );
            }
        }

        return $url;
    }

    /**
     * set images
     *
     * @param $images
     * @return $this
     */
    public function setImages($images)
    {
        return $this->setData('images', $images);
    }

    /**
     * set files
     *
     * @param $files
     * @return $this
     */
    public function setFiles($files)
    {
        return $this->setData('files', $files);
    }
}
