<?php

namespace Vashchak\FilesCatalog\Model\Object;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Retrieve options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return self::getOptionArray();
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        $statuses = \Vashchak\FilesCatalog\Block\Grid\Renderer\Status::getAllStatusesArray();

        $options = [];
        foreach ($statuses as $id => $label) {
            $options[$id] = ['value' => $id, 'label' => $label];
        }

        return $options;
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        return self::getOptionArray();
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();
        return $options[$optionId]['label'] ?? null;
    }
}