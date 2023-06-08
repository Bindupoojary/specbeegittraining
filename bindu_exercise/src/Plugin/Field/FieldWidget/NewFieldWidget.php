<?php

namespace Drupal\bindu_exercise\Plugin\Field\FieldWidget;

// This class serves as the base class for field widgets in Drupal.
use Drupal\Core\Field\WidgetBase;
// Imports the FieldItemListInterface interface.
use Drupal\Core\Field\FieldItemListInterface;
// Imports the FormStateInterface interface from the Drupal\Core\Form namespace.
use Drupal\Core\Form\FormStateInterface;

/**
 * Define the "custom field type".
 *
 * @FieldWidget( #This line indicates the start of the @FieldWidget annotation.
 *   id = "custom_field_widget", //specifies the ID of the custom field widget
 *   label = @Translation("Custom Field Widget"),   //sets the label for the custom field widget
 *   description = @Translation("Desc for Custom Field Widget"), //description for  custom field widget
 *   field_types = {     //field type the custom field widget supports.
 *     "custom_field_type"
 *   }
 * )
 */
class NewFieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // Generating the form element for the custom field widget.
    // If it is  empty string is assigned.
    $value = $items[$delta]->value ?? "";

    $element = $element + [
    // Sets the #type property of the element to 'textfield.
      '#type' => 'textfield',
    // Content of string is obtained from the field setting named "moreinfo" .
      '#suffix' => "<span>" . $this->getFieldSetting("moreinfo") . "</span>",
    // Sets the #default_value property.
      '#default_value' => $value,
    // Value of 'placeholder' attribute is obtained from  widget's placeholder.
      '#attributes' => [
        'placeholder' => $this->getSetting('placeholder'),
      ],
    ];
    return ['value' => $element];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    // Define the default settings for the custom field widget.
    return [
    // Specifies the default settings for the widget.
      'placeholder' => 'default',

    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    // Represent the form input for the 'placeholder' setting of the widget.
    $element['placeholder'] = [
    // Form element should be rendered as a textfield.
      '#type' => 'textfield',
    // This string will be displayed as the label for the form element.
      '#title' => 'Placeholder text',
      '#default_value' => $this->getSetting('placeholder'),
    ];
    // Returns the $element array,.
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    // Generating a summary of the settings for the custom field widget.
    // This line initializes an empty array called $summary.
    $summary = [];
    // Displays the label placeholder text with  value of placeholder setting.
    $summary[] = $this->t("placeholder text: @placeholder", ["@placeholder" => $this->getSetting("placeholder")]);
    // Returns the $summary array.
    return $summary;
  }

}
