<?php
namespace Drupal\d8training\EventSubscriber;

/// Creating sevice
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class EventManager implements EventSubscriberInterface
{
  public static function getSubscribedEvents(){
     $events[KernelEvents::RESPONSE][] = array('addTestHeader'); // addTestHeader is an function
     return $events;
  }

  public function addTestHeader(FilterResponseEvent $event) {
    $res = $event->getResponse();
    $res->headers->add(['Access-control-allow-origin-*']);

  }

}
