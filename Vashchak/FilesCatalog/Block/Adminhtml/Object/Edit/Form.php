<?php

namespace Vashchak\FilesCatalog\Block\Adminhtml\Object\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Form
 * @package Vashchak\FilesCatalog\Block\Adminhtml\Object\Edit
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
        $this->setId('object_form');
        $this->setTitle(__('Object Information'));
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->_coreRegistry->registry('vashchak_filescatalog_object');
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

        $form->setHtmlIdPrefix('object_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        }

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => [
                    '0' => __(\Vashchak\FilesCatalog\Block\Grid\Renderer\Status::getStatusText(0)),
                    '1' => __(\Vashchak\FilesCatalog\Block\Grid\Renderer\Status::getStatusText(1)),
                ]
            ]
        );

        $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Title'), 'title' => __('Title'), 'required' => true,]
        );

        $fieldset->addField(
            'description',
            'editor',
             [
                'name'      => 'description',
                'label'     => __('Description'),
                'title'     => __('Description'),
                'style'     => 'height: 300px;',
                'wysiwyg'   => true,
                'required'  => false,
            ]
        );

        $fieldset->addField(
            'keywords',
            'text',
            [
                'name' => 'keywords',
                'label' => __('Keywords'),
                'title' => __('Keywords'),
            ]
        );

        $fieldset->addField(
            'images_upload',
            'image',
            ['name' => 'image', 'label' => __('Images'), 'title' => __('Images')]
        );

        $fieldset->addField(
            'created_at',
            'label',
            ['name' => 'created_at', 'label' => __('Created At'), 'title' => __('Created At')]
        );

        $fieldset->addField(
            'updated_at',
            'label',
            ['name' => 'updated_at', 'label' => __('Updated At'), 'title' => __('Updated At')]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
