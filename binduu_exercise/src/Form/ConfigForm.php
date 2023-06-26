<?php

namespace Drupal\binduu_exercise\Form;

// Defines the namespace for the form class.
use Drupal\Core\Form\ConfigFormBase;
// Imports the ConfigFormBase class.
use Drupal\Core\Form\FormStateInterface;

/**
 * Imports the FormStateInterface.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * Settings Variable.
   */
  const CONFIGNAME = "binduu_exercise_form.settings";


  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return "binduu_exercise_form_settings";
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    // Returns the name of the configuration objects.
    return [
      static::CONFIGNAME,
    ];
  }

/**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $form['helptext'] = [
            '#type' => 'textfield',
            '#title' => 'Help Text',
            '#default_value' => $config->get("helptext"),
        ];

        // Token support.
        if (\Drupal::moduleHandler()->moduleExists('token')) {
            $form['tokens'] = [
                '#title' => $this->t('Tokens'),
                '#type' => 'container',
            ];
            $form['tokens']['help'] = [
                '#theme' => 'token_tree_link',
                '#token_types' => [
                'node',
                'site',
                ],
                // '#token_types' => 'all'
                '#global_types' => FALSE,
                '#dialog' => TRUE,
            ];
        }

        return Parent::buildForm($form, $form_state);
    }



}
