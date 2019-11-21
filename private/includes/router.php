<?php
class router {

    function get_routes () {
        // Localhost version
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));

        // Online version
        // $uri = $_SERVER['REQUEST_URI'];
        // if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($url, '?'));


        $uri = '/' . trim($uri, '/');
        $uri_routes = array();
        $uri_routes = explode('/', $uri);
        $routes = array();
        foreach($uri_routes as $route) {
            if(trim($route))
                array_push($routes, $route);
        }

        if (count($routes) === 0) {
            array_push($routes, "home");
        }
        // echo "Routes:<br><pre>";
        // var_dump($routes);
        // echo "</pre>";
        // echo "uri: " . $_SERVER['REQUEST_URI'] . "<br>$uri";
        // echo "uri_routes: ";
        // print_r($uri_routes);
        // die();

        // Check if u are allowed to be, if u are logged in
        $not_allowed_places = ['settings', 'profile'];
        $not_allowed_places_loggedin = ['login', 'register'];

        ($routes[0] != "template") ? $request = $routes[0] : $request = $routes[1];

        foreach ($not_allowed_places as $place) {
            if (!isset($_SESSION['ssid']) && $request == $place) return array('home');
        }

        foreach ($not_allowed_places_loggedin as $place) {
            if (isset($_SESSION['ssid']) && $request == $place) return array('home');
        }

        if (isset($_SESSION['valid_user']) && $routes[0] != 'settings') unset($_SESSION['valid_user']);

        if ($routes[0] == 'settings' && !isset($_SESSION['valid_user'])) return array("validate");

        return $routes;
    }
}