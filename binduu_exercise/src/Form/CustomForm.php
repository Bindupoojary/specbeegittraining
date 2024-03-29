<?php

namespace Drupal\binduu_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;

/**
 * Form Interactions.
 */
class CustomForm extends FormBase {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The database service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * CustomForm constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   */
  public function __construct(MessengerInterface $messenger, Connection $database) {
    $this->messenger = $messenger;
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form_user_details';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attached']['library'][] = "binduu_exercise/customjsform";
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => 'First Name',
      '#required' => TRUE,
      '#placeholder' => 'First Name',
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => 'Email',
    ];
    $form['gender'] = [
      '#type' => 'select',
      '#title' => 'Gender',
      '#options' => [
        'male' => 'Male',
        'female' => 'Female',
      ],
    ];
    $form['permanent'] = [
      '#type' => 'textfield',
      '#title' => 'permanent',
      '#placeholder' => 'permanent address',
    ];
    $form['check'] = [
      '#type' => 'checkbox',
      '#title' => 'same as permanent',
    ];

    $form['temporary'] = [
      '#type' => 'textfield',
      '#placeholder' => 'temporary address',
      '#title' => 'temporary',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
      '#ajax' => [
          'callback' => '::setAjaxSubmit',
      ],
  ];

  return $form;
}

public function setAjaxSubmit() {
  $response = new AjaxResponse();
  $response->addCommand(new InvokeCommand("html", 'datacheck'));
  return $response;
}


/**
 * {@inheritdoc}
 */
public function validateForm(array &$form, FormStateInterface $form_state) {
  $email = $form_state->getValue('email');
  if (!preg_match('/^\S+@\S+\.\S+$/', $email)) {
    $form_state->setErrorByName('email', $this->t('Invalid email address.'));
  }
}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger->addMessage("User Details Submitted Successfully");
    $this->database->insert("user_details")->fields([
      'firstname' => $form_state->getValue("firstname"),
      'email' => $form_state->getValue("email"),
      'gender' => $form_state->getValue("gender"),
    ])->execute();
  }

}
