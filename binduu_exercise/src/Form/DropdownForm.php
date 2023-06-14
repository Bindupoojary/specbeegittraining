<?php

namespace Drupal\binduu_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\node\Entity\Node;
use Drupal\Core\Database\Database;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;


class DropdownForm extends FormBase {

 /**
   * The database service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

   /**
   * CustomForm constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   */
  public function __construct( Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dropdown_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
        $country_id=$form_state->getValue("country");
        $state_id=$form_state->getValue("state");
    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t(' Select Country'),
      '#options' => $this->getCountryOptions(),
      '#empty_option' => $this->t('- Select -'),
      '#ajax' => [
        'callback' => [$this, 'ajaxStateDropdownCallback'],
        'wrapper' => 'state-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ],
    ];

    $form['state'] = [
      '#type' => 'select',
      '#title' => $this->t(' Select State'),
      '#options' => $this->getstateOptions( $country_id),
      '#prefix' => '<div id="state-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => $this->t('- Select -'),
      '#disabled' => FALSE,
      '#ajax' => [
        'callback' => [$this, 'ajaxDistrictDropdownCallback'],
        'wrapper' => 'district-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ],
    ];

    $form['district'] = [
      '#type' => 'select',
      '#title' => $this->t(' Select District'),
      '#options' => $this->getDistrictsByState($state_id),
      '#prefix' => '<div id="district-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => $this->t('- Select -'),
      '#disabled' => FALSE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission if needed.
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
    $query = $this->database->select('country', 'c');
    $query->fields('c', ['id', 'name']);
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }

    return $options;
  }
  private function getstateOptions( $country_id){

    // Fetch the states for the selected country
    $query = $this->database->select('state', 's');
    $query->fields('s', ['id', 'name']);
    $query->condition('s.country_id',  $country_id);
    $result = $query->execute();

    // Iterate over the result to retrieve the state information
    $states = [];
    foreach ($result as $row) {
      $states[$row->id] = $row->name;
    }
    return $states;
  }

  function getDistrictsByState( $state_id) {
    $query = $this->database->select('district', 'd');
    $query->fields('d', ['id', 'name']);
    $query->condition('d.state_id', $state_id);
    $result = $query->execute();

    $districts = [];
    foreach ($result as $row) {
      $districts[$row->id] = $row->name;
    }

    return $districts;
  }
}