<?php

namespace Drupal\bindu_exercise\Form;

// Base class for creating Drupal forms.
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class customform extentds formbase.
 */
class CustomForm extends FormBase {

  /**
   * Generated form id.
   */
  public function getFormId() {
    // Defines the unique ID for the form.
    // Returns the form id.
    return 'custom_form_user_details';
  }

  /**
   * Build form generates form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // First field.
    $form['firstname'] = [
    // Field type is textfield.
      '#type' => 'textfield',
    // Title of the field.
      '#title' => 'First Name',
    // Required field.
      '#required' => TRUE,
    // Value that should display in placeholder.
      '#placeholder' => 'First Name',
    ];
    // Email field.
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => 'Email',
    ];
    // Gender field.
    $form['gender'] = [
    // Field type is select.
      '#type' => 'select',
      '#title' => 'Gender',
      '#options' => [
    // Can select either male or female.
        'male' => 'Male',
        'female' => 'Female',
      ],
    ];
    // Provides the submit button.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    // Returns the form so that the form will be displayed.
    return $form;

  }

  /**
   * Submit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Function to submit the form
    // Service which displays the msg when the form is submitted.
    \Drupal::messenger()->addMessage("User Details Submitted Successfully");
    // Inserting the form values to the table.
    \Drupal::database()->insert("user_task")->fields([
    // Inserting value to the firstname field.
      'firstname' => $form_state->getValue("firstname"),
    // Inserting value to the email field.
      'email' => $form_state->getValue("email"),
    // Inserting value to the geneder field.
      'gender' => $form_state->getValue("gender"),
    ])->execute();

  }

}
