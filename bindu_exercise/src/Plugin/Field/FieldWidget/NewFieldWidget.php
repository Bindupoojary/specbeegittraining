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
            '#type' => 'textfield',                                                                                                            #sets the #type property of the element to 'textfield
            '#suffix' => "<span>" . $this->getFieldSetting("moreinfo") . "</span>",                                                            # content of the string is obtained from the field setting named "moreinfo" using the getFieldSetting method
            '#default_value' => $value,                                                                                                        # sets the #default_value property
            '#attributes' => [                                                                                                                 #The value of the 'placeholder' attribute is obtained from the widget's 'placeholder' setting using the getSetting method.
                'placeholder' => $this->getSetting('placeholder'),
            ],
        ];
        return ['value' => $element];                       # returns an array with a single key-value pair, where the key is 'value' and the value is the updated $element
     }

     /**
      * {@inheritdoc}
      */
      public static function defaultSettings() {  #This function is used to define the default settings for the custom field widget.
        return [
            'placeholder' => 'default', #specifies the default settings for the widget.
        ] + parent::defaultSettings();  #e merges the default settings defined in the parent class with the current widget's default settings
      }

      /**
       * {@inheritdoc}
       */
      public function settingsForm(array $form, FormStateInterface $form_state) {       #responsible for generating the form elements for the settings of the custom field widget.
        $element['placeholder'] = [                                                  #represent the form input for the 'placeholder' setting of the widget
            '#type' => 'textfield',                                                 #form element should be rendered as a textfield.
            '#title' => 'Placeholder text',                                         #This string will be displayed as the label for the form element.
            '#default_value' => $this->getSetting('placeholder'),                   #sets the #default_value property of the element to the value of the 'placeholder' setting obtained using the getSetting method of the current widget
        ];
        return $element;                                                       #returns the $element array, which contains the form elements representing the settings for the custom field widget
      }

      /**
       * {@inheritdoc}
       */
      public function settingsSummary() {  #responsible for generating a summary of the settings for the custom field widget.
        $summary = [];                     #This line initializes an empty array called $summary, which will store the summary information for the widget's settings.
        $summary[] = $this->t("placeholder text: @placeholder", array("@placeholder" => $this->getSetting("placeholder"))); # creates a summary entry that displays the label "placeholder text" along with the actual value of the 'placeholder' setting.
        return $summary;  #returns the $summary array, which contains the summary information for the custom field widget's settings.
      }


}