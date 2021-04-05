<?php

namespace Light;

class Light
{
    private array $routes = [];
    private array $slugs
                          = [
            "",
            "/:",
            "/:/:",
            "/:/:/:",
            "/:/:/:/:",
            "/:/:/:/:/:",
            "/:/:/:/:/:/:",
            "/:/:/:/:/:/:/:",
            "/:/:/:/:/:/:/:/:",
            "/:/:/:/:/:/:/:/:/:",
        ];
    
    public function get($path, $handle)
    {
        $this->add($path, $handle, "GET");
    }
    
    public function add($path, $handle, $method)
    {
        //$handle = explode("@", $handle);
        $this->routes[$method][($path != "/") ? rtrim($path, "/") : "/"] = [
            "path" => $path,
            "c"    => $handle[0],
            "m"    => $handle[1]
        ];
    }
    
    public function post($path, $handle)
    {
        $this->add($path, $handle, "POST");
    }
    
    public function put($path, $handle)
    {
        $this->add($path, $handle, "PUT");
    }
    
    public function patch($path, $handle)
    {
        $this->add($path, $handle, "PATCH");
    }
    
    public function delete($path, $handle)
    {
        $this->add($path, $handle, "DELETE");
    }
    
    public function start()
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? null;
        
        $uri = $this->getUri();
        
        $urie = explode("/", $uri);
        
        $urie = array_slice($urie, 1);
        
        $len = count($urie);
        
        
        if (isset($this->routes[$method][rtrim($uri)])) {
            $this->call_class_method($method, rtrim($uri), $urie);
        } else {
            for ($i = 1; $i < $len; $i++) {
                $req_path = dirname($uri, $i) . $this->slugs[$i];
                if (isset($this->routes[$method][$req_path])) {
                    $this->call_class_method($method, $req_path, array_slice($urie, $len - $i));
                    exit(0);
                }
            }
            if ($uri == "/" or $uri == "") {
                if (isset($this->routes[$method]["/"])) {
                    $this->call_class_method($method, "/", $urie);
                } else {
                    echo "404";
                }
            } else {
                if (isset($this->routes[$method][$this->slugs[$len]])) {
                    $this->call_class_method($method, $this->slugs[$len], $urie);
                } else {
                    echo "404";
                }
            }
        }
    }
    
    public function getUri()
    {
        $uri = $_SERVER['PATH_INFO'] ?? null;
        //soporte para $_SERVER['PATH_INFO'] $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/");
        
        $uri = filter_var($uri, FILTER_SANITIZE_URL);
        
        return $uri;
    }
    
    public function call_class_method($method, $link, $params)
    {
        $c    = $this->routes[$method][$link]["c"];
        $m    = $this->routes[$method][$link]["m"];
        $call = new $c();
        $call->$m(...$params);
    }
    
}