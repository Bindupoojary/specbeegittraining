<?php

namespace Drupal\bindu_exercise\Form;             # defining the namespace for the CustomForm class, which is located in the Form directory of the 'bindu_exercise' module.
use Drupal\Core\Form\FormBase;                    #base class for creating Drupal forms.
use Drupal\Core\Form\FormStateInterface;          #used to manage the state of a form between requests. It provides methods for setting and getting form values, handling errors, and other form-related tasks.

class CustomForm extends FormBase {               #class customform extentds formbase

    // generated form id
    public function getFormId()                   #is a method of the CustomForm class that defines the unique ID for the form.
    {
        return 'custom_form_user_details';         #returns the form id
    }

    // build form generates form

    public function buildForm(array $form, FormStateInterface $form_state) {       # helps to build the form


        $form['firstname'] = [                             # first field
            '#type' => 'textfield',                       # field type is textfield
            '#title' => 'First Name',                    #title of the field
            '#required' => true,                        #  required field
            '#placeholder' => 'First Name',           #  valuee that should display in placeholder
        ];
        $form['email'] = [                        # email field
            '#type' => 'textfield',              # field type is textfield
            '#title' => 'Email',                 #title of the field
        ];
        $form['gender'] = [                      #gender field
            '#type' => 'select',                 #field type is select
            '#title' => 'Gender',                # title of the field
            '#options' => [                      # select option
                'male' => 'Male',                # can select either male or female
                'female' => 'Female',
            ],
        ];
        $form['submit'] = [                      # provides the submit button
            '#type' => 'submit',                # which is of submit type
            '#value' => 'Submit',              # name of the submit button
        ];
        return $form;                        # returns the form so that the form will be displayed

    }

    public function submitForm(array &$form, FormStateInterface $form_state)        # function to submit the form
    {

        \Drupal::messenger()->addMessage("User Details Submitted Successfully");     #its a service which displayes the msg when the form is submitted
        \Drupal::database()->insert("user_task")->fields([                           #inserting the form values to the table
            'firstname' => $form_state->getValue("firstname"),                      # inserting value to the firstname field
            'email' => $form_state->getValue("email"),                              #inserting value to the email field
            'gender' => $form_state->getValue("gender"),                             #inserting value to the geneder field
        ])->execute();                                                              #

    }
}


