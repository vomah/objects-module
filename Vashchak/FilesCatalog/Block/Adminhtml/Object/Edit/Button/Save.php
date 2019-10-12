<?php
namespace Vashchak\FilesCatalog\Block\Adminhtml\Object\Edit\Button;

use Magento\Ui\Component\Control\Container;

/**
 * Class Save
 */
class Save extends Generic
{
  /**
   * {@inheritdoc}
   */
  public function getButtonData()
  {
    return [
      'label' => __('Save'),
      'class' => 'save primary',
      'data_attribute' => [
        'mage-init' => [
          'buttonAdapter' => [
            'actions' => [
              [
                'targetName' => 'object_form.object_form',
                'actionName' => 'save',
                'params' => [
                  false
                ]
              ]
            ]
          ]
        ]
      ],
      'class_name' => Container::SPLIT_BUTTON,
    ];
  }
}
