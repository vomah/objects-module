<?php

namespace Vashchak\FilesCatalog\Block\Adminhtml;

/**
 * Class Category
 * @package Vashchak\FilesCatalog\Block\Adminhtml
 */
class Category extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_category';
        $this->_blockGroup = 'Vashchak_FilesCatalog';
        $this->_headerText = __('Categories');
        $this->_addButtonLabel = __('Add Category');
        parent::_construct();
    }

    /**
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->getUrl('*/*/edit');
    }
}
