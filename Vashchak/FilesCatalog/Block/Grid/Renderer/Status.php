<?php

namespace Vashchak\FilesCatalog\Block\Grid\Renderer;

/**
 * Class Status
 * @package Vashchak\FilesCatalog\Block\Grid\Renderer
 */
class Status extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Statuses
     */
    const STATUS_ENABLED = 0;
    const STATUS_DISABLED = 1;

    /**
     * @var array
     */
    protected static $statusesTexts = [
        self::STATUS_ENABLED => 'Enabled',
        self::STATUS_DISABLED => 'Disabled',
    ];

    /**
     * Renders grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        return '<span>' . self::getStatusText($row->getStatus()) . '</span>';
    }

    /**
     * @param int|string $status
     * @return mixed|string
     */
    public static function getStatusText($status)
    {
        return self::$statusesTexts[(int)$status] ?? '';
    }
}
