<?php

namespace Drupal\bindu_exercise\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Define the "custom field formatter".
 *
 * @FieldFormatter(
 *   id = "custom_field_formatter", // The unique ID of the field formatter.
 *   label = @Translation("Custom Field Formatter"), // The label for the field formatter.
 *   description = @Translation("Desc for Custom Field Formatter"), // The description of the field formatter.
 *   field_types = {
 *     "custom_field_type" // Field types that this formatter can be applied to.
 *   }
 * )
 */
class FieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
    // Default value for the 'concat' setting.
      'concat' => 'Concat with ',
    // Merge with the default settings of the parent class.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['concat'] = [
    // Defines the form element type as a textfield.
      '#type' => 'textfield',
    // The label for the textfield in the form.
      '#title' => 'Concatenate with',
    // The default value of the textfield, fetched from the current settings.
      '#default_value' => $this->getSetting('concat'),
    ];
    // Return the form array.
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    // Initialize an empty array to store the summary information.
    $summary = [];
    $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]);
    // Return the summary array.
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    // Initialize an empty array to store the renderable elements.
    $element = [];

    foreach ($items as $delta => $item) {
      $element[$delta] = [
              // Concatenates the 'concat' setting value with the item's value.
        '#markup' => $this->getSetting('concat') . $item->value,
      ];

    }

    // Return the array of renderable elements.
    return $element;
  }

}
