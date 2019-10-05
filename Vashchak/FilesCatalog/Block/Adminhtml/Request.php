<?php

namespace Vashchak\FilesCatalog\Block\Adminhtml;

/**
 * Class Request
 * @package Vashchak\FilesCatalog\Block\Adminhtml
 */
class Request extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_request';
        $this->_blockGroup = 'Vashchak_FilesCatalog';
        $this->_headerText = __('Requests');
        $this->_addButtonLabel = __('Add');
        parent::_construct();
        $this->removeButton('add');
    }
}
