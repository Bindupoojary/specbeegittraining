<?php

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Implements the example form.
 */
class DependentDropdownForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dependent_dropdown_example_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $count = $form_state->getValue('country');

    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#options' => $this->getCountryOptions(),
      '#empty_option' => $this->t('- Select -'),
      'default_value' => $count,
      '#ajax' => [
        'callback' => [$this, 'ajaxStateDropdownCallback'],
        'wrapper' => 'state-dropdown-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ],
    ];
    $stat = $form_state->getValue('state');
    $form['state'] = [
      '#type' => 'select',
      '#title' => $this->t('State'),
      '#prefix' => '<div id="state-dropdown-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => $this->t('- Select -'),
      'default_value' => $stat,
      '#options' => $this->getStateOptions($count),
    //   '#disabled' => TRUE,
      '#ajax' => [
        'callback' => [$this, 'ajaxDistrictDropdownCallback'],
        'wrapper' => 'district-dropdown-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ],
    ];

    $form['district'] = [
      '#type' => 'select',
      '#title' => $this->t('District'),
      '#prefix' => '<div id="district-dropdown-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => $this->t('- Select -'),
      '#options' => $this->getDistrictOptions($state),

    //   '#disabled' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * Ajax callback for the state dropdown.
   */
  public function ajaxStateDropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['state'];
  }

  /**
   * Ajax callback for the district dropdown.
   */
  public function ajaxDistrictDropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['district'];
  }

  /**
   * Helper function to retrieve country options.
   */
  private function getCountryOptions() {
    $query = Database::getConnection()->select('country', 'c');
    $query->fields('c', ['id', 'name']);
    $query->condition();
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }

    return $options;
  }

  private function getStateOptions($count) {
    $query = Database::getConnection()->select('state', 's');
    $query->fields('s', ['id', 'name']);
    $query->condition('s.id', 'id' );
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }

    return $options;
  }

  private function getStateOptions($stat) {
    $query = Database::getConnection()->select('district', 'd');
    $query->fields('d', ['id', 'name']);
    $query->condition('d.id', 'id' );
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }

    return $options;
  }

}