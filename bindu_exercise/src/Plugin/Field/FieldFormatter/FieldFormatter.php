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
 *     "custom_field_type" // The field types that this formatter can be applied to.
 *   }
 * )
 */


class FieldFormatter extends FormatterBase {

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() {
        return [
            'concat' => 'Concat with ', // Default value for the 'concat' setting.
        ] + parent::defaultSettings(); // Merge with the default settings of the parent class.
    }
    /**
     * {@inheritdoc}
     */

     public function settingsForm(array $form, FormStateInterface $form_state) {
        $form['concat'] = [
            '#type' => 'textfield', // Defines the form element type as a textfield.
            '#title' => 'Concatenate with', // The label for the textfield in the form.
            '#default_value' => $this->getSetting('concat'), // The default value of the textfield, fetched from the current settings.
        ];
        return $form; // Return the form array.
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        $summary = []; // Initialize an empty array to store the summary information.
        $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]);
        // Add a summary entry to the array using the translated string and the value of the 'concat' setting.
        return $summary; // Return the summary array.
    }


    /**
     * {@inheritdoc}
     */

     public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = []; // Initialize an empty array to store the renderable elements.

        foreach ($items as $delta => $item) {
            $element[$delta] = [
                '#markup' => $this->getSetting('concat') . $item->value,
            ];
            // Create a renderable element with a '#markup' property that concatenates the 'concat' setting value with the item's value.
        }

        return $element; // Return the array of renderable elements.
    }


}