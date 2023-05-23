<?php

namespace Drupal\redirecting_task\EventSubscriber;


use Symfony\Component\HttpFoundation\RedirectResponse;   # part of the Symfony web framework and is used to create a response that redirects the user's browser to a different URL.
use Symfony\Component\HttpKernel\KernelEvents;           # class that contains a list of event names related to the Symfony HTTP kernel.
use Symfony\Component\HttpKernel\Event\RequestEvent;   # part of the Symfony web framework and represents an event that occurs when an HTTP request is received by the application.
use Symfony\Component\EventDispatcher\EventSubscriberInterface;  # part of the Symfony framework and is used to define event subscribers.

/**
 * Class CustomRedirects
 * @package Drupal\redirecting_task\EventSubscriber
 *
 * Redirects /admin/content/* to '/admin/modules/*'
 */
class Redirect implements EventSubscriberInterface {   # defines a class called Redirect that implements the EventSubscriberInterface.

  public function checkForRedirection(RequestEvent $event) {   #declares a method called checkForRedirection that takes a RequestEvent object as a parameter.


    $request = $event->getRequest();     #This line retrieves the Request object from the RequestEvent parameter.
    $path = $request->getRequestUri();   # retrieves the request URI  from the Request object.
    if(strpos($path, 'admin/content') !== false) {    #checks if the $path string contains the substring 'admin/content'. The strpos() function is used to perform this check.
      // Redirect old  urls
      $new_url = str_replace('admin/content','admin/modules', $path);  #creates a new URL by replacing the 'admin/content' substring in $path with 'admin/modules'. The str_replace() function is used for this replacement.
      $new_response = new RedirectResponse($new_url, '301');  # creates a new RedirectResponse object, specifying the $new_url as the target URL and '301' as the HTTP status code for permanent redirection.


      $new_response->send();    #This line sends the redirect response to the client's browser, initiating the redirection.
    }

    // This is necessary because this also gets called on
    // node sub-tabs such as "edit", "revisions", etc.  This
    // prevents those pages from redirected.
    if ($request->attributes->get('_route') !== 'entity.node.canonical') {  #checks if the current route  is not equal to 'entity.node.canonical'.
      return;
    }

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {   # declares a static method called getSubscribedEvents().

    $events[KernelEvents::REQUEST][] = array('checkForRedirection', 29);   #The code sets up an event subscription for the KernelEvents::REQUEST event with a priority of 29.
    return $events;
  }

}