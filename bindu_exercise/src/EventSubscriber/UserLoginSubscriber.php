<?php

namespace Drupal\bindu_exercise\EventSubscriber;

use Drupal\custom_events\Event\UserLoginEvent; // Import the UserLoginEvent class from the custom_events module.
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserLoginSubscriber.
 *
 * @package Drupal\bindu_exercise\EventSubscriber
 */
class UserLoginSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // Return an array mapping the event name to the method that should handle it.
    return [
      UserLoginEvent::EVENT_NAME => 'onUserLogin', // When UserLoginEvent is triggered, call the onUserLogin method.
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\bindu_exercise\Event\UserLoginEvent $event
   *   Our custom event object.
   */
  public function onUserLogin(UserLoginEvent $event) {
    // Perform actions when the user login event is triggered.
    $database = \Drupal::database(); // Access the database service.
    $dateFormatter = \Drupal::service('date.formatter'); // Access the date formatter service.

    // Fetch the account creation date for the logged-in user.
    $account_created = $database->select('users_field_data', 'ud')
      ->fields('ud', ['created'])
      ->condition('ud.uid', $event->account->id())
      ->execute()
      ->fetchField();

    // Display a status message with the formatted account creation date.
    \Drupal::messenger()->addStatus(t('Hello, your account was created on %created_date.', [
      '%created_date' => $dateFormatter->format($account_created, 'short'),
    ]));
  }

}
