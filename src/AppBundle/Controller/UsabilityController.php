<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UsabilityController
 *
 * I added this class for some user-friendly features like: remove trailing slashes etc.
 *
 * @package AppBundle\Controller
 */
class UsabilityController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeTrailingSlashAction(Request $request)
    {
        $pathInfo   = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);
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


        if ($matchingRoute['_controller'] === 'AppBundle\Controller\UsabilityController::localeRedirectAction'){
            throw $this->createNotFoundException();
        }

        return $this->forward($matchingRoute['_controller']);
    }
}