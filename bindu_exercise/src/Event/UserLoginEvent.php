<?php

namespace Drupal\bindu_exercise\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\user\UserInterface;

/**
 * Event that executes when a user logs in.
 */
class UserLoginEvent extends Event {

  const EVENT_NAME = 'custom_events_user_login';

  /**
   * The user account.
   *
   * @var \Drupal\user\UserInterface
   */
  public $account;

  /**
   * Constructs the object.
   *
   * @param \Drupal\user\UserInterface $account
   *    The account of the user logged in.
   */
  public function __construct(UserInterface $account) {
    $this->account = $account;
  }

}