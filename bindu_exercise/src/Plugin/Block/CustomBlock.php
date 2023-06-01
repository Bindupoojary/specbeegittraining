<?php

 namespace Drupal\bindu_exercise\Plugin\Block;   # These lines declare the namespace for the block plugin class and import necessary classes for it.

 use Drupal\Core\Block\BlockBase;
 use Drupal\Core\Form\FormStateInterface;

/**
  * Provides simple block for d4drupal.
  * @Block (
  * id = "new taskk",
  * admin_label = "new task"
  * )
  */

  class CustomBlock extends BlockBase{            #declares a new class named "CustomBlock" that extends the "BlockBase" class.
    /**
     * {@inheritdoc}                                   #provides a docblock for the "build" function and indicates that it is overriding the "build" function of the "BlockBase" class.
     */

  //   public function build() {                         #declares a new public function named "build" for the "CustomBlock" class.



  //       $form =\Drupal::formBuilder()->getForm('\Drupal\bindu_exercise\Form\CustomForm'); #This line retrieves the form object for the custom form class, "\Drupal\bindu_exercise\Form\CustomForm", using the form builder service.
  //       return $form;
  //     }

  // }
  public function build() {                         #declares a new public function named "build" for the "CustomBlock" class.



    $form =\Drupal::formBuilder()->getForm('\Drupal\bindu_exercise\Form\CustomConfigForm'); #This line retrieves the form object for the custom form class, "\Drupal\bindu_exercise\Form\CustomForm", using the form builder service.
    return $form;
  }

}
