<?php

namespace Drupal\bindu_exercise\EventSubscriber;

// Import the UserLoginEvent class .
use Drupal\custom_events\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserLoginSubscriber.
 *
 * @package Drupal\bindu_exercise\EventSubscriber
 */

/**
 * Event that executes when a user logs in.
 */
class UserLoginSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // Return an array mapping the event name to the method.
    return [
    // When UserLoginEvent is triggered, call the onUserLogin method.
      UserLoginEvent::EVENT_NAME => 'onUserLogin',
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
    // Access the database service.
    $database = \Drupal::database();
    // Access the date formatter service.
    $dateFormatter = \Drupal::service('date.formatter');

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
