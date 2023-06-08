<?php

namespace Drupal\bindu_exercise\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Define the "custom field type".
 *
 * @FieldType( #indicates the beginning of an annotation for defining a field type
 *   id = "custom_field_type",            // ID for the custom field type.
 *   label = @Translation("Custom Field Type"),           // Sets the label for the custom field type.
 *   description = @Translation("Desc for Custom Field Type"),   // Sets the description for the custom field type.
 *   category = @Translation("Text"),                         // Assigns the custom field type to a specific category, such as "Text".
 *   default_widget = "custom_field_widget",     // Defines the default widget
 *   default_formatter = "custom_field_formatter",  // Specifies the default
 * )
 */
class FieldType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    // Return statement returns an array that represents the schema definition.
    return [
    // Represents the columns within the table associated with field type.
      'columns' => [
    // Here is a single column named 'value'.
        'value' => [
    // 'value' is defined as a varchar type
          'type' => 'varchar',
          'length' => $field_definition->getSetting("length"),
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    // Returns an array that represents the default storage settings.
    return [
    // length' with a value of 255.
      'length' => 255,
    // Merge the default storage settings with parent default setting.
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $element = [];

    $element['length'] = [
    // Specifies the type of the field as a number input.
      '#type' => 'number',
    // Sets the title or label for the field.
      '#title' => t("Length of your text"),
    // Indicates that the field is required.
      '#required' => TRUE,
    // Sets the default value for the field.
      '#default_value' => $this->getSetting("length"),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    // Returns an array that represents the default field settings.
    return [
    // Setting named 'moreinfo' with a value of "More info default value".
      'moreinfo' => "More info default value",
    ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    // Initializes an empty array to store the elements.
    $element = [];
    // Adds a new array element with the key 'moreinfo' to the $element array.
    $element['moreinfo'] = [
    // Type of the element as a textfield.
      '#type' => 'textfield',
      '#title' => 'More information about this field',
      '#required' => TRUE,
    // Sets the default value .
      '#default_value' => $this->getSetting("moreinfo"),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // In this case, the property is named 'value'.
    $properties['value'] = DataDefinition::create('string')->setLabel(t("Name"));

    return $properties;
  }

}
