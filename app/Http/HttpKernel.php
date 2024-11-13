<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class HttpKernel
{
    private RouteCollection $loadedRouteCollection;

    private UrlMatcher $urlMatcher;

    private RequestContext $requestContext;

    public function __construct(RouteCollection $loadedRouteCollection)
    {
        $this->loadedRouteCollection = $loadedRouteCollection;
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest(Request::createFromGlobals());
        $this->urlMatcher = new UrlMatcher($this->loadedRouteCollection, $this->requestContext);
    }

    public function handle(string $requestUri)
    {
        try
        {
            $parameters = $this->urlMatcher->match($requestUri);
            $request = Request::createFromGlobals();
            $controller = $parameters['_controller'];
            $action = $parameters['_action'];
            unset(
                $parameters['_controller'],
                $parameters['_action'],
                $parameters['_route'],
            );
            $controllerInstance = new $controller();
            call_user_func_array([$controllerInstance, $action], array_merge([$request], array_values($parameters)));
        }
        catch(ResourceNotFoundException|\Exception $exception)
        {
            die($exception->getMessage());
        }
    }
}
