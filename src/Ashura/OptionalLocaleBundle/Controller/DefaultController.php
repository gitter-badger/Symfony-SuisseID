<?php

namespace Ashura\OptionalLocaleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 *
 * @package Ashura\OptionalLocaleBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/ashura/optional_locale_test_route", name="ashura_optional_locale_homepage_route")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('OptionalLocaleBundle:Default:index.html.twig', array(
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            )
        );
    }

    /**
     * This route decides wheater a request has a missing locale or it is a missing page
     *
     * @param Request $request
     *
     * @return Response
     */
    public function localeRedirectAction(Request $request)
    {
        $requestUri  = $request->getRequestUri();
        $explodedUri = explode('/', $requestUri);
        $doubleSlash = substr($requestUri, 0, 2) === '//';

        if (!$doubleSlash){ // does not start with 2 slashes

            if (strlen($explodedUri[1]) !== 2){ // no locale supplied
                $matchingRoute = $this->get('router')->match("/".$requestUri);
            } else{

                // 404
                throw $this->createNotFoundException();
            }
        } else{

            $requestUri = substr($requestUri, 2); // Removed first 2 slashes

            $locale = (empty($request->getLocale())) ? $request->getDefaultLocale() : mb_substr($request->getLocale(),
                0, 2
            );

            $requestUri = '/'.$locale.'/'.$requestUri;

            $matchingRoute = $this->get('router')->match($requestUri);
        }

        if ($matchingRoute['_controller'] === 'Ashura\OptionalLocaleBundle\Controller\DefaultController::localeRedirectAction'){
            throw $this->createNotFoundException();
        }

        return $this->forward($matchingRoute['_controller']);
    }
}