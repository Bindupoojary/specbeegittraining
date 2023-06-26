<?php

namespace Drupal\binduu_exercise\Controller;

use Drupal\Core\Controller\ControllerBase;

class CustomModal extends ControllerBase {

    public function modalLink() {
        $build['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $build = [
            '#markup' => '<a href="/drupal-10.0.9/get-user/details" class="use-ajax" data-dialog-type="modal">Click here</a>',
        ];
        return $build;
    }

}