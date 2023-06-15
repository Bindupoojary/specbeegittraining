<?php

namespace Drupal\binduu_exercise\EventSubscriber;

use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\binduu_exercise\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserLoginSubscriber.
 *
 * @package Drupal\binduu_exercise\EventSubscriber
 */
class CustomConfigEventsSubscriber implements EventSubscriberInterface {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * CustomConfigEventsSubscriber constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(Connection $database, MessengerInterface $messenger) {
    $this->database = $database;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      /* Static class constant => method on this class. */
      UserLoginEvent::EVENT_NAME => 'onUserLogin',
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\binduu_exercise\Event\UserLoginEvent $event
   *   Our custom event object.
   */
  public function onUserLogin(UserLoginEvent $event) {
    // Format timestamp into date time.
    $dateFormatter = \Drupal::service('date.formatter');

    // Fetch user data.
    $account_created = $this->database->select('users_field_data', 'ud')
      // Returns when the account was created.
      ->fields('ud', ['created'])
      // Returns user id.
      ->condition('ud.uid', $event->account->id())
      ->execute()
      ->fetchField();

    $this->messenger->addStatus(t('Welcome, your account was created on %created_date.', ['%created_date' => $dateFormatter->format($account_created, 'short')]));
  }

}
