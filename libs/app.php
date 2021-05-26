<?php

    require_once 'controllers/errores.php';

    class App
    {
        function __construct()
        {
            //echo "<p>Nueva app</p>";
            $url = isset($_GET['url']) ? $_GET['url']: null;
            $url = rtrim($url, '/');
            $url = explode('/', $url);


            //cuando se ingresar sin definir controlador redirección
            if(empty($url[0]))
            {
                $archivoController = 'controllers/main.php';
                require_once $archivoController;
                $controller = new Main(); 
                $controller->loadModel('main');
                $controller->render();
                return false;
            }

            $archivoController = 'controllers/' . $url[0] . '.php';

            if(file_exists($archivoController))
            {
                require_once $archivoController;

                //inicalizamos el cotrolador y cargamos el modelo
                $controller = new $url[0];
                $controller->loadModel($url[0]); 

                //si hay un metodo que se requiere cargar
                if(isset($url[1]))
                {
                    $controller->{$url[1]}();
                }else{
                    $controller->render();
                }              
            }
            else
            {
                $controller = new Errores(); 
            }

        }
    }

?>
