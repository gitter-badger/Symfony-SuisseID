<?php
/**
 * Created by PhpStorm.
 * User: Dominik Müller (Ashura)
 * Date: 13.12.15
 *
 * @link http://aimei.ch/developers/Ashura
 */

namespace Ashura\OptionalLocaleBundle\EventListener;


use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LocaleListener
 *
 * @package Ashura\OptionalLocaleBundle\EventListener
 */
class LocaleListener implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->hasPreviousSession()){ // First visit
            $request->getSession()->set('_locale', $request->getPreferredLanguage());
            $request->setLocale($request->getPreferredLanguage());

            return;
        }

        $locale = $request->attributes->get('_locale');

        // try to see if the locale has been set as a _locale routing parameter
        if (empty($locale)){ // No _locale supplied
            $request->setLocale($request->getSession()->get('_locale'));
        }
    }
}