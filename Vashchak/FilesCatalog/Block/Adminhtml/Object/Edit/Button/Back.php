<?php

namespace Vashchak\FilesCatalog\Block\Adminhtml\Object\Edit\Button;

/**
 * Class Back
 */
class Back extends Generic
{
  /**
   * @return array
   */
  public function getButtonData()
  {
    return [
      'label' => __('Back'),
      'on_click' => sprintf("location.href = '%s';", $this->getUrl('*/*/')),
      'class' => 'back',
      'sort_order' => 10
    ];
  }
}
