<?php

namespace Drupal\Dependent\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;

class DependentForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dependent_dropdown_Form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Retrieve the options for the first dropdown (category).
    $opt = $this->location();

    // Retrieve the selected values from the form state, or set them to 'none' if not available.
    $cat = $form_state->getValue('category') ?: 'none';
    $avai = $form_state->getValue('availableitems') ?: 'none';

    // Category dropdown.
    $form['category'] = [
      '#type' => 'select',
      '#title' => 'Country',
      '#options' => $opt,
      'default_value' => $cat,
      '#ajax' => [
        'callback' => '::DropdownCallback',  // AJAX callback method for this dropdown.
        'wrapper' => 'field-container',  // HTML ID of the element to update via AJAX.
        'event' => 'change',  // Trigger the AJAX callback on change event.
      ],
    ];

    // Available items dropdown.
    $form['availableitems'] = [
      '#type' => 'select',
      '#title' => 'State',
      '#options' => static::availableItems($cat),  // Generate options based on the selected category.
      '#default_value' => !empty($form_state->getValue('availableitems')) ? $form_state->getValue('availableitems') : 'none',
      '#prefix' => '<div id="field-container"',  // HTML prefix for the element.
      '#suffix' => '</div>',  // HTML suffix for the element.
      '#ajax' => [
        'callback' => '::DropdownCallback',  // AJAX callback method for this dropdown.
        'wrapper' => 'dist-container',  // HTML ID of the element to update via AJAX.
        'event' => 'change',  // Trigger the AJAX callback on change event.
      ],
    ];

    // District dropdown.
    $form['district'] = [
      '#type' => 'select',
      '#title' => 'District',
      '#options' => static::district($avai),  // Generate options based on the selected available items.
      '#default_value' => !empty($form_state->getValue('district')) ? $form_state->getValue('district') : '',
      '#prefix' => '<div id="dist-container"',  // HTML prefix for the element.
      '#suffix' => '</div>',  // HTML suffix for the element.
    ];

    // Submit button.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $trigger = (string) $form_state->getTriggeringElement()['#value'];

    // If the triggering element is not the submit button, set the form state to rebuild.
    if ($trigger != 'submit') {
      $form_state->setRebuild();
    }
  }

  /**
   * AJAX callback method for the dependent dropdowns.
   */
  public function DropdownCallback(array &$form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
    $triggering_element_name = $triggering_element['#name'];

    if ($triggering_element_name === 'category') {
                                                                 // Return the available items dropdown to update via AJAX.
      return $form['availableitems'];
    } elseif ($triggering_element_name === 'availableitems') {
                                                                             // Return the district dropdown to update via AJAX.
      return $form['district'];
    }
  }

  /**
   * Get the options for the category dropdown.
   */
  public function location() {
    return [
      'none' => '-none-',
      'india' => 'India',
    ];
  }

  /**
   * Get the options for the available items dropdown based on the selected category.
   */
  public function availableItems($cat) {
    switch ($cat) {
      case 'india':
        $opt = [
          'karnataka' => 'Karnataka',
          'kerala' => 'Kerala',
        ];
        break;
      default:
        $opt = ['none' => '-none-'];
        break;
    }
    return $opt;
  }

  /**
   * Get the options for the district dropdown based on the selected available items.
   */
  public function district($avai) {
    switch ($avai) {
      case 'karnataka':
        $opt = [
          'kodagu' => 'Kodagu',
          'bangalore' => 'Bangalore',
          'mangalore' => 'Mangalore',
        ];
        break;
      case 'kerala':
        $opt = [
          'kasargod' => 'Kasargod',
          'trivandrum' => 'Trivandrum',
        ];
        break;
    }
    return $opt;
  }
}
