<?php

namespace Drupal\semi_split\Entity;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;

/**
 *
 */
class SemiSplitListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [
      'label' => $this->t('Configuration semi split'),
      'id' => $this->t('Machine name'),
      'description' => $this->t('Description'),
    ];
    return $header + parent::buildHeader();
  }

}
