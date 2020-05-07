<?php

namespace OCFram;

abstract class Application
{
    protected $httpRequest;
    protected $httpResponse;
    protected $name;
    protected $user;
    protected $config;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);      
        $this->name = '';
        $this->user = new User($this);
        $this->config = new Config($this);
    }
    
    public function getController()
    {
        $router = new Router;

        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../../App/'.$this->name.'/Config/routes.xml');

        $routes = $xml->getElementsByTagName('route');

        foreach ($routes as $route)
        {
            $vars = [];
            
            if ($route->hasAttribute('vars'))
            {
                $vars = explode(',', $route->getAttribute('vars'));
            }

            $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
        }

        try
        {
            $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
        }
        catch (\RuntimeException $e)
        {
            if ($e->getCode() == Router::NO_ROUTE)
            {
                $this->httpResponse->redirect404();
            }
        }

        //ON ajoute les variables de l'URL au tableau $_GET
        $_GET = array_merge($_GET, $matchedRoute->vars());

        //On instancie le controleur
        $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller'; 
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
    }
    
    /**
     * @return void
     */
    abstract public function run();

    /**
     * @return HTTPRequest
     */
    public function httpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * @return HTTPResponse
     */
    public function httpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * @return string 
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Config
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }
}