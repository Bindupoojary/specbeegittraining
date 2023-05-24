<?php

namespace Drupal\bindu_exercise\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;             #This class serves as the base class for field widgets in Drupal.
use Drupal\Core\Field\FieldItemListInterface; #This line imports the FieldItemListInterface interface from the Drupal\Core\Field namespace.
use Drupal\Core\Form\FormStateInterface;      #imports the FormStateInterface interface from the Drupal\Core\Form namespace.

/**
 * Define the "custom field type".
 *
 * @FieldWidget(                                                    #This line indicates the start of the @FieldWidget annotation.
 *   id = "custom_field_widget",                                    #specifies the ID of the custom field widget
 *   label = @Translation("Custom Field Widget"),                   #sets the label for the custom field widget
 *   description = @Translation("Desc for Custom Field Widget"),    #description for the custom field widget
 *   field_types = {                                                #specifies a single field type that the custom field widget supports.
 *     "custom_field_type"
 *   }
 * )
 */

class NewFieldWidget extends WidgetBase {

    /**
     * {@inheritdoc}
     */

     public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {        # function is responsible for generating the form element for the custom field widget.
        $value = isset($items[$delta]->value) ? $items[$delta]->value : "";                                                                    #If it is set, the value is assigned to the $value variable otherwise, an empty string is assigned.
        $element = $element + [                                                                                                                #assigns the $element variable to itself plus an array, combining any existing element properties with the ones specified in the following array.
            '#type' => 'textfield',
            '#suffix' => "<span>" . $this->getFieldSetting("moreinfo") . "</span>",
            '#default_value' => $value,
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
        return [
            'placeholder' => 'default',
        ] + parent::defaultSettings();
      }

      /**
       * {@inheritdoc}
       */
      public function settingsForm(array $form, FormStateInterface $form_state) {
        $element['placeholder'] = [
            '#type' => 'textfield',
            '#title' => 'Placeholder text',
            '#default_value' => $this->getSetting('placeholder'),
        ];
        return $element;
      }

      /**
       * {@inheritdoc}
       */
      public function settingsSummary() {
        $summary = [];
        $summary[] = $this->t("placeholder text: @placeholder", array("@placeholder" => $this->getSetting("placeholder")));
        return $summary;
      }


}