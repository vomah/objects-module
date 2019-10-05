<?php

namespace Vashchak\FilesCatalog\Block\Adminhtml\Request\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Form
 * @package Vashchak\FilesCatalog\Block\Adminhtml\Request\Edit
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
        $this->setId('request_form');
        $this->setTitle(__('Request Information'));
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->_coreRegistry->registry('vashchak_filescatalog_request');
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

        $form->setHtmlIdPrefix('request_');

        $fieldset = $form->addFieldset(
          'base_fieldset',
          ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('request_id', 'hidden', ['name' => 'request_id']);
        }

        $fieldset->addField(
          'status',
          'select',
          [
            'label' => __('Status'),
            'title' => __('Status'),
            'name' => 'status',
            'required' => true,
            'options' => ['0' => __('New'), '1' => __('Processed'),]
          ]
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

        $fieldset->addField(
          'name',
          'label',
          ['name' => 'name', 'label' => __('Name'), 'title' => __('Name')]
        );

        $fieldset->addField(
          'email',
          'label',
          ['name' => 'email', 'label' => __('Email'), 'title' => __('Email')]
        );

        $fieldset->addField(
          'phone',
          'label',
          ['name' => 'phone', 'label' => __('Phone Number'), 'title' => __('Phone Number')]
        );

        $fieldset->addField(
          'message',
          'label',
          [
            'name' => 'message',
            'label' => __('Message'),
            'title' => __('Message'),
          ]
        );

        $fieldset->addField(
          'reply',
          'editor',
          [
            'name' => 'reply',
            'label' => __('Reply to client'),
            'title' => __('Reply to client'),
            'style' => 'height:25em',
            'required' => false
          ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
