<?php

namespace Drupal\redirecting_task\EventSubscriber;

use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CustomRedirects
 * @package Drupal\redirecting_task\EventSubscriber
 *
 * Redirects /news/* to '/blog/*'
 */
class Redirect implements EventSubscriberInterface {

  public function checkForRedirection(RequestEvent $event) {

    $request = $event->getRequest();
    $path = $request->getRequestUri();
    if(strpos($path, 'admin/content') !== false) {
      // Redirect old  urls
      $new_url = str_replace('admin/content','admin/modules', $path);
      $new_response = new RedirectResponse($new_url, '301');
      $new_response->send();
    }

    // This is necessary because this also gets called on
    // node sub-tabs such as "edit", "revisions", etc.  This
    // prevents those pages from redirected.
    if ($request->attributes->get('_route') !== 'entity.node.canonical') {
      return;
    }

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    //The dynamic cache subscribes an event with priority 27. If you want that your code runs before that you have to use a priority >27:
    $events[KernelEvents::REQUEST][] = array('checkForRedirection', 29);
    return $events;
  }

}