<?php

namespace Router;

use Database\DBConnection;

class Route{

    public $path;
    public $action;
    public $matches;

    public function __construct($path, $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    /**
     * Verifie si le chemin passe existe
     */
    public function matches(string $url)
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        if (preg_match($pathToMatch, $url, $matches)){
            $this->matches = $matches;
            return true;
        } else {
            return false;
        }
    }
  

    /**Analyse de la route =>'/posts/:id', 'App\Controllers\BlogController@show' */ 
    public function execute()  
    {
        $params = explode('@', $this->action);
        $controller = new $params[0](new DBConnection('myapp','localhost', 'root', 'root'));                   
        $method = $params[1];

        return isset($this->matches[1]) ? $controller->$method($this->matches[1]) :
        $controller->$method();
    }
}