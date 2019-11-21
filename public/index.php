<?php

// passw = 'ihatemylife'

session_start();

// -------------------------------------------------------------------------------

$debug = false;

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if ($debug) {

    $debug_id = '9927b06e-509d-4222-b0b9-10646486bb73';
    $load_login = true;
    $view_users = true;
    $wrong_passw = false;

    if (isset($_SESSION['debug_id'])) {
        if ($_SESSION['debug_id'] === $debug_id) {
            $load_login = false;
        }
    } elseif (isset($_POST['debug_login']) && isset($_POST['passw'])) {
        $passw = filter_var($_POST['passw'], FILTER_SANITIZE_STRING);
        if ($passw == 'ihatemylife') {
            $_SESSION['debug_id'] = $debug_id;
            header("location: ./");
        } else {
            echo "wrong";
        }
    }

    if ($load_login) {
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Work in progress</title>
            </head>
            <body>
                <form action="./" method="post">
                    <h1>Website is under construction.</h1>
                    <?php
                        if ($wrong_passw) {
                            ?>
                                <h2>Password incorrect</h2>
                            <?php
                        }
                    ?>
                    <input type="password" name="passw" placeholder="login to view website">
                    <button type="submit" name="debug_login">submit</button>
                </form>
            </body>
            </html>
        <?php
    } elseif ($view_users) {
        require "../private/models/model.php";
        $model = new model;
        $users_data = $model->show_users()
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Users</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    flex-direction: column;
                    /* align-items: center; */
                }

                .user:nth-child(odd) {
                    background: #ffffff;
                }
                .user:nth-child(even) {
                    background: #eeeeee;
                }
            </style>
        </head>
        <body>
            <?php
                foreach ($users_data as $user) {
                    $user = (array) $user;
                    echo "<div class='user'>";
                    foreach ($user as $key => $value) {
                        ?>

                        <div class="thing">
                            <span><?=$key?></span>
                            <span><?=$value?></span>
                        </div>

                        <?php
                    }
                    echo "</div class='user'>";
                }
            ?>
        </body>
        </html>

        <?php
        die();
    }
}

// -------------------------------------------------------------------------------

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        // Ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

if (!filter_var(getUserIpAddr(), FILTER_VALIDATE_IP)) {
    echo "incorrect ip address";
    die();
}

// -------------------------------------------------------------------------------

$connected_ip = getUserIpAddr();

$date = date("Y d m G i s", time());
// $date = getdate();
$new_user = true;

$json_file = "../private/user_data.json";

$obj = json_decode(file_get_contents($json_file, true));

foreach ($obj->recent_ips as $user) {
    if ($connected_ip == $user->ip) {
        $new_user = false;
        $user->last_seen = $date;
    }
}

if ($new_user) array_push($obj->recent_ips, (object) array("ip" => "$connected_ip", "last_seen" => $date));

file_put_contents($json_file, json_encode($obj));

// print_r(json_decode(file_get_contents($json_file, true)));

// ---------------------------------------------------------------------------------

require "../private/models/model.php";

$GLOBALS['uri'] = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
$GLOBALS['request_uri'] = '/RLSETTINGS/public/';
// $GLOBALS['request_uri'] = '/';
$uri = $GLOBALS['uri'];

if (isset($_SESSION['ssid'])) {
    $model = new model;
    $user_info = $model->get_user_info($_SESSION['ssid']);
    if (!$user_info) {
        $uri .= "logout";
        header("location: $uri");
    }
    $GLOBALS['user_info'] = $user_info;
    $GLOBALS['user_camera'] = $model->get_user_camera($user_info->global_id);
    echo "has ssid";
}

require "../private/includes/router.php";

$router = new router;

$routes = $router->get_routes();

if (isset($_SESSION['valid_user']) && $routes[0] != 'settings') unset($_SESSION['valid_user']);

if ($routes[0] == 'logout') {
    session_destroy();
    header("location: $uri");
}

$special_requests = array(
    'main',
    'template',
    'search'
);

$index = array_search($routes[0], $special_requests);

if (!$index) { $controller = 'main'; } else { $controller = $special_requests[$index]; }

$controller .= "Controller";

require "../private/controllers/" . $controller . ".php";

$controller = new $controller;

$controller->load($routes);