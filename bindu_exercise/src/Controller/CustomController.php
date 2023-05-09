<?php

namespace Drupal\bindu_exercise\Controller;      # defining the namespace for the CustomForm class, which is located in the Form directory of the 'bindu_exercise' module.

use Drupal\Core\Controller\ControllerBase;        #This class serves as a base class for creating controllers in Drupal

class CustomController extends ControllerBase {    #class CustomController extends ControllerBase

    public function hello() {                  #This is a public method named hello which does not take any arguments.
      $route = \Drupal::service('bindu_exercise')->getName();
      print_r($route);
      //exit;
        $hexcode = $this->configuration['hexcode'];   #his assigns the value of the hexcode  to a variable $hexcode.
        $element = [                               #his creates an array called $element with three keys: #theme, #text, and #hexcode.
          '#theme' => "block_plugin_template",        #The #theme key specifies the theme hook name,
          '#text' =>  "welcome all",                  #text contains the text to be displayed
          '#hexcode' => $this->configuration['hexcode'],  ##hexcode contains the value of $hexcode
        ];
          return $element;                      #return the array

    }


}