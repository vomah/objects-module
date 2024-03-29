<?php

namespace Vashchak\FilesCatalog\Block\Adminhtml\Category\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\App\ObjectManager;

/**
 * Class Form
 * @package Vashchak\FilesCatalog\Block\Adminhtml\Category\Edit
 */
class Form extends Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('category_form');
        $this->setTitle(__('Category Information'));
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->_coreRegistry->registry('vashchak_filescatalog_category');
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->getModel();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('category_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Title'), 'title' => __('Title'), 'required' => true,]
        );

        $categoryCollection = $this->getCategoryCollection($model->getId() ?: 0);
        $fieldset->addField(
            'parent_id',
            'select',
            [
                'name' => 'parent',
                'label' => __('Choose parent'),
                'title' => __('Choose parent'),
                'required' => false,
                'values' => $categoryCollection->toOptionArray()
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @param int|null $id
     * @return mixed
     */
    protected function getCategoryCollection($id)
    {
        $category = ObjectManager::getInstance()->get('\Vashchak\FilesCatalog\Model\ResourceModel\Category\CollectionFactory');

        $collection = $category->create()
            ->addFieldToSelect('*');

        if ($id) {
            $collection->addFieldToFilter(
                'entity_id',
                ['neq' => $id]
            )->addFieldToFilter(
                'parent_id',
                ['neq' => $id]
            );
        }

        return $collection;
    }
}
