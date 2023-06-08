<?php

namespace Drupal\bindu_exercise\Controller;

// This class serves as a base class for creating controllers in Drupal.
use Drupal\Core\Controller\ControllerBase;

/**
 * Its a Controller.
 */
class CustomController extends ControllerBase {
  // Class CustomController extends ControllerBase.

  /**
   * Hello function.
   */
  public function hello() {
    // This is a public method named hello which does not take any arguments.
    $route = \Drupal::service('bindu_exercise')->getName();
    print_r($route);
    // exit;.
    // This assigns the value of the hexcode  to a variable $hexcode.
    $hexcode = $this->configuration['hexcode'];
    // Creates an array called $element with three keys:#theme, #text,#hexcode.
    $element = [
    // The #theme key specifies the theme hook name,.
      '#theme' => "block_plugin_template",
    // Text contains the text to be displayed.
      '#text' => "welcome all",
    // Hexcode contains the value of $hexcode.
      '#hexcode' => $this->configuration['hexcode'],
    ];
    // Return the array.
    return $element;

  }

}
