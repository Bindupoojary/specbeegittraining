<?php

namespace Drupal\bindu_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides simple block for d4drupal.
 *
 * @Block (
 * id = "new taskk",
 * admin_label = "new task"
 * )
 */
class CustomBlock extends BlockBase {
  // Declares a new class named CustomBlock that extends the BlockBase.
  /**
   * {@inheritdoc}
   */

  /**
   * Declares a new public function named "build" for the "CustomBlock" class.
   */
  public function build() {
    // This line retrieves the form object for the custom.
    $form = \Drupal::formBuilder()->getForm('\Drupal\bindu_exercise\Form\CustomForm');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Declares a new public function named "build" for the "CustomBlock" class.
    // This line retrieves the form object.
    $form = \Drupal::formBuilder()->getForm('\Drupal\bindu_exercise\Form\CustomConfigForm');
    return $form;
  }

}
