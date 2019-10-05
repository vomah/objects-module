<?php

namespace Vashchak\FilesCatalog\Block\Adminhtml;

/**
 * Class Category
 * @package Vashchak\FilesCatalog\Block\Adminhtml
 */
class Category extends \Magento\Backend\Block\Widget\Tree
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_object';
        $this->_blockGroup = 'Vashchak_FilesCatalog';
        $this->_headerText = __('Objects');
        $this->_addButtonLabel = __('Add');
        parent::_construct();
        $this->removeButton('add');
    }
}
