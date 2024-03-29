<?php

namespace Vashchak\FilesCatalog\Block\Adminhtml\Category;

/**
 * Class Edit
 * @package Vashchak\FilesCatalog\Block\Adminhtml\Category
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Edit constructor.
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param array                                 $data
     */
    public function __construct(
      \Magento\Backend\Block\Widget\Context $context,
      \Magento\Framework\Registry $registry,
      array $data = []
    ) {
        $this->_coreRegistry = $registry;

        $this->_formScripts[] = " function duplicate(url) {
           jQuery('#edit_form').attr('action', url);
           $('edit_form').submit();
        }";

        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'Vashchak_FilesCatalog';
        $this->_controller = 'adminhtml_category';
        $this->_headerText = __('Edit Category');
        parent::_construct();

        $this->prepareButtons();
        $this->registerModel();
    }

    protected function prepareButtons()
    {
        if ($this->_isAllowedAction('Vashchak_FilesCatalog::save_category')) {
            $this->buttonList->update('save', 'label', __('Save'));
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Vashchak_FilesCatalog::delete_category')) {
            $this->buttonList->update('delete', 'label', __('Delete'));
        } else {
            $this->buttonList->remove('delete');
        }

        $this->buttonList->remove('reset');
    }

    protected function registerModel()
    {
        $id = $this->getRequest()->getParam('entity_id');
        /** @var \Vashchak\FilesCatalog\Model\Category $model */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('Vashchak\FilesCatalog\Model\Category');

        if ($id) {
            $model->load($id);
        }

        $this->_coreRegistry->register('vashchak_filescatalog_category', $model);
    }

    /**
     * @return mixed
     */
    public function getCustomUrl()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $urlManager = $objectManager->get('Magento\Framework\Url');
        return $urlManager->getUrl('admin/*/*/edit');
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->_coreRegistry->registry('vashchak_filescatalog_category');
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getHeaderText()
    {
        if ($this->getModel()->getId()) {
            return __("Edit '%1'", $this->escapeHtml($this->getModel()->getTitle()));
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
