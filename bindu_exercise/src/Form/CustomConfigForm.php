<?php

namespace Drupal\bindu_exercise\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Config form.
 */
class CustomConfigForm extends ConfigFormBase {

  /**
   * Settings Variable.
   */
  const CONFIGNAME = "bindu_exercise.settings";

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return "bindu_config_form_settings";
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::CONFIGNAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::CONFIGNAME);
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => ' <p>name</p>',
      '#attached' => [
        'library' => [
          'bindu_exercise/css_lib',
        ],
      ],
      '#default_value' => $config->get("name"),

    ];

    $form['place'] = [
      '#type' => 'textfield',
      '#title' => 'place',
      '#default_value' => $config->get("place"),
    ];

    $form['age'] = [
      '#type' => 'textfield',
      '#title' => 'age',
      '#default_value' => $config->get("age"),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config(static::CONFIGNAME);
    $config->set("name", $form_state->getValue('name'));
    $config->set("place", $form_state->getValue('place'));
    $config->set("age", $form_state->getValue('age'));
    $config->save();
  }

}
