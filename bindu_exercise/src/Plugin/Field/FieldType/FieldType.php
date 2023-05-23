<?php

namespace Drupal\bindu_exercise\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Define the "custom field type".
 *
 * @FieldType(                                             #indicates the beginning of an annotation for defining a field type
 *   id = "custom_field_type",                            #specifies the unique identifier for the custom field type.
 *   label = @Translation("Custom Field Type"),           #sets the label for the custom field type, using the @Translation annotation for translation purposes.
 *   description = @Translation("Desc for Custom Field Type"),   #sets the description for the custom field type, using the @Translation annotation for translation purposes.
 *   category = @Translation("Text"),                         # assigns the custom field type to a specific category, such as "Text".
 *   default_widget = "custom_field_widget",                 #defines the default widget used to render this field type.
 *   default_formatter = "custom_field_formatter",           #specifies the default formatter used to display the field type's value.
 * )
 */

class FieldType extends FieldItemBase {

    /**
     * {@inheritdoc}
     */

    public static function schema(FieldStorageDefinitionInterface $field_definition) {
        return [                                                        #return statement returns an array that represents the schema definition
            'columns' => [                                              #represents the columns within the table associated with the custom field type.
                'value' => [                                            #here is a single column named 'value'.
                    'type' => 'varchar',                                #'value' is defined as a varchar type
                    'length' => $field_definition->getSetting("length"),# column with a length specified by $field_definition->getSetting("length").
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultStorageSettings() {
        return [                                      #   returns an array that represents the default storage settings.
            'length' => 255,                         #length' with a value of 255.
        ] + parent::defaultStorageSettings();              #merge the default storage settings defined in the current class with the default storage settings inherited from the parent class (parent::defaultStorageSettings()).
    }

    /**
     * {@inheritdoc}
     */
    public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
        $element = [];

        $element['length'] = [
            '#type' => 'number',                      // Specifies the type of the field as a number input
            '#title' => t("Length of your text"),     // Sets the title or label for the field
            '#required' => TRUE,                      // Indicates that the field is required
            '#default_value' => $this->getSetting("length"), // Sets the default value for the field based on the "length" setting of the custom field type
        ];
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultFieldSettings() {
        return [                                      #returns an array that represents the default field settings.
            'moreinfo' => "More info default value",  #setting named 'moreinfo' with a value of "More info default value".
        ] + parent::defaultFieldSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
        $element = [];                   # initializes an empty array to store the elements.
        $element['moreinfo'] = [           # adds a new array element with the key 'moreinfo' to the $element array.
            '#type' => 'textfield',         #type of the element as a textfield
            '#title' => 'More information about this field',
            '#required' => TRUE,
            '#default_value' => $this->getSetting("moreinfo"),  # sets the default value .
        ];
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function PropertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties['value'] = DataDefinition::create('string')->setLabel(t("Name"));               #This line adds a new property definition to the $properties array. In this case, the property is named 'value'.

        return $properties;
    }
}