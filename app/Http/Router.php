<?php

namespace App\Http;

use App\Http\Middleware\Queue as MiddlewareQueue;
use Closure;
use Exception;
use ReflectionFunction;

class Router{

    /**
     * @var string
     */
    private $url = '';

    /**
     * @var string
     */
    private $prefix = '';

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * 
     */
    private function setPrefix()
    {
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute(string $method, string $route, array $params = [])
    {
        foreach($params as $key => $value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }
        $params['middlewares'] = $params['middlewares'] ?? [];
        $params['variables'] = [];

        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)){
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //Padrao de validacao de url
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * @param string $route
     * @param array $params
     */
    public function get(string $route, array $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * @param string $route
     * @param array $params
     */
    public function post(string $route, array $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * @param string $route
     * @param array $params
     */
    public function put(string $route, array $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * @param string $route
     * @param array $params
     */
    public function delete(string $route, array $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    /**
     * @return string
     */
    private function getUri()
    {
        $uri = $this->request->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        $xUri = rtrim(end($xUri), '/');

        if($xUri == ''){
            $xUri = '/';
        }
        
        return $xUri;
    }

    /**
     * @return array
     */
    private function getRoute(): ?array
    {
        $uri = $this->getUri();

        $httpMethod = $this->request->getHttpMethod();

        foreach($this->routes as $patternRoute => $methods){
            if(preg_match($patternRoute, $uri, $matches)){
                if(isset($methods[$httpMethod])){
                    unset($matches[0]);
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;
                    return $methods[$httpMethod];
                }

                throw new Exception("Metodo nao permitido", 405);
            }
        }

        throw new Exception("URL nao encontrada", 404);
    }

    /**
     * @return Response
     */
    public function run()
    {
        try{
            $route = $this->getRoute();
            
            if(!isset($route['controller'])){
                throw new Exception("A url nao pode ser processada", 500);
            }

            $args = [];

            $reflection = new ReflectionFunction($route['controller']);

            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);
        }catch(Exception $e){
            return new Response($e->getCode(), $this->getErrorMessage($e->getMessage()), $this->contentType);
        }
    }

    /**
     * @param string $message
     * @return mixed
     */
    private function getErrorMessage(string $message): mixed
    {
        switch($this->contentType){
            case 'application/json':
                return [
                    'error' => $message
                ];
                break;
            default:
                return $message;
                break;
        }
    }

    /**
     * @return string
     */
    public function getCurrentUrl(): string
    {
        return $this->url . $this->getUri();
    }

    /**
     * @param string $route
     */
    public function redirect(string $route)
    {
        $url = $this->url . $route;

        header('location: '. $url);
        exit;
    }
}