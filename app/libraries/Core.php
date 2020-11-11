<?php


/**
 * Class Core
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class Core
{
    /**
     * @var mixed|string
     */
    protected $currentController = 'Pages';
    /**
     * @var mixed|string
     */
    protected $currentMethod = 'index';
    /**
     * @var array|false|string[]
     */
    protected  $params = [];

    /**
     * Core constructor.
     */
    public function __construct()
    {
        $url = $this->getUrl();

        //Regarde 1ere valeur 'controllers ; ucwords 1ere lettre en capital
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            //Définie un nouveau controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        //Require the controlller
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        //Check la 2eme partie de l'url
        if (isset($url[1])){
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            }

        }
        //Get parameters
        $this->params = $url ? array_values($url) : [];

        //Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }


    /**
     * @return false|string[]
     */
    public function getUrl()
    {
        if (isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
                // filtrer la variable string/number
            $url = filter_var($url, FILTER_SANITIZE_URL);
                // place dans un tableau
            $url = explode('/', $url);
            return $url;
        }
    }

}