<?php

namespace Drupal\bindu_exercise\Controller;      # defining the namespace for the CustomForm class, which is located in the Form directory of the 'bindu_exercise' module.

use Drupal\Core\Controller\ControllerBase;        #This class serves as a base class for creating controllers in Drupal

class CustomController extends ControllerBase {    #class CustomController extends ControllerBase

    public function hello() {
        $hexcode = $this->configuration['hexcode'];
        $element = [
          '#theme' => "block_plugin_template",
          '#text' =>  "welcome all",
          '#hexcode' => $this->configuration['hexcode'],
        ];
          return $element;

    }


}