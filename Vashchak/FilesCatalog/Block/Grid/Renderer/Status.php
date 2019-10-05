<?php

namespace Vashchak\FilesCatalog\Block\Grid\Renderer;

/**
 * Class Status
 * @package Vashchak\FilesCatalog\Block\Grid\Renderer
 */
class Status extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    const STATUS_NEW = 'New';
    const STATUS_PROCESSED = 'Processed';

    /**
     * Renders grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $status = !(int)$row->getStatus() ? self::STATUS_NEW : self::STATUS_PROCESSED;
        return '<span>' . $status . '</span>';
    }
}
