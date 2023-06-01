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
    $opt = $this->location();
    $cat = $form_state->getValue('category') ?: 'none';
    $avai = $form_state->getValue('availableitems') ?: 'none';
    $form['category'] = [
        '#type' => 'select',
        '#title' => 'country',
        '#options' => $opt,
        'default_value' => $cat,
        '#ajax' => [
            'callback' => '::DropdownCallback',
            'wrapper' => 'field-container',
            'event' => 'change'
        ]
    ];
    $form['availableitems'] = [
        '#type' => 'select',
        '#title' => 'state',
        '#options' =>static::availableItems($cat),
        '#default_value' => !empty($form_state->getValue('availableitems')) ? $form_state->getValue('availableitems') : 'none',
        '#prefix' => '<div id="field-container"',
        '#suffix' => '</div>',
        '#ajax' => [
          'callback' => '::DropdownCallback',
          'wrapper' => 'dist-container',
          'event' => 'change'
      ]
    ];
    $form['district'] = [
          '#type' => 'select',
          '#title' => 'district',
          '#options' =>static::district($avai),
          '#default_value' => !empty($form_state->getValue('district')) ? $form_state->getValue('district') : '',
          '#prefix' => '<div id="dist-container"',
          '#suffix' => '</div>',
    ];
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
    if ($trigger != 'submit') {
        $form_state->setRebuild();
    }
  }

  public function DropdownCallback(array &$form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
    $triggering_element_name = $triggering_element['#name'];

    if ($triggering_element_name === 'category') {
      return $form['availableitems'];
    }
    elseif ($triggering_element_name === 'availableitems') {
      return $form['district'];
    }


  }

  public function location() {
    return [
        'none' => '-none-',
        'india' => 'india',
    ];
  }

  public function availableItems($cat) {
    switch ($cat) {
        case 'india':
            $opt = [
                'karnataka' => 'karnataka',
                'kerala' => 'kerala',
            ];
        break;
        default:
          $opt = ['none' => '-none-'];
        break;
    }
    return $opt;
  }

  public function district($avai) {
    switch($avai) {
      case 'karnataka':
        $opt = [
          'kodagu' => 'kodagu',
          'bangalore' => 'bangalore',
          'mangalore' => 'mangalore',
        ];
      break;
      case 'kerala':
        $opt = [
          'kasargod' => 'kasargod',
          'trivandrum' => 'trivandrum',
        ];
      break;
    }
    return $opt;
  }



}