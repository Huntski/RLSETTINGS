<?php

class mainController {
    public function load ($routes) {

        $loading = false;

        $model = new model;

        $error = '';
        $error_msg = '';

        // ------------------ Check if something has been submitted ------------------

        if (!isset($GLOBALS['user_info'])) {
            if ($routes[0] === 'login') {
                if (isset($_POST['login_submit'])) {

                    if (isset($_POST['email'], $_POST['passw'])) {
                        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error_msg = "Email is not email.";

                        if (empty($_POST['email']) || empty($_POST['passw'])) $error_msg = "All fields are required.";

                        if (!$error_msg) {
                            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

                            $response = $model->login_user($email, $_POST['passw']);

                            if (is_array($response)) {
                                $error_msg = $response[1];
                            } else {
                                $_SESSION['ssid'] = $response;
                                $uri = $GLOBALS['request_uri'];
                                header("location: $uri");
                            }
                        }
                    } else {
                        $error_msg = "All fields are required.";
                    }
                }
            } elseif ($routes[0] === 'register') {
                if (isset($_POST['register_submit'])) {

                    if (isset($_POST['r_email'], $_POST['r_passw'], $_POST['r_usern'])) {

                        if (!filter_var($_POST['r_email'], FILTER_VALIDATE_EMAIL)) $error_msg = "Email is not email.";

                        if (empty($_POST['r_email']) || empty($_POST['r_passw']) || empty($_POST['r_usern'])) $error_msg = "All fields are required.";

                        if (!$error_msg) {

                            $email = filter_var($_POST['r_email'], FILTER_SANITIZE_EMAIL);
                            $passw = password_hash($_POST['r_passw'], PASSWORD_ARGON2I);
                            $usern = filter_var($_POST['r_usern'], FILTER_SANITIZE_STRING);
                            $ssid = $model->generate_uuid();

                            $response = $model->register_user($global_id, $ssid, $email, $passw, $usern);

                            if (!$response) {
                                $error_msg = "Email already exist.";
                            } else {
                                $_SESSION['ssid'] = $response;
                                $uri = $GLOBALS['request_uri'];
                                header("location: $uri");
                            }
                        }
                    } else {
                        $error_msg = "All fields are required.";
                    }
                }
            }
        } elseif ($routes[0] === 'profile') {
            if (isset($_POST['camera_submit'])) {

                $they_fckt_with_code = false;

                $posts = ['f', 'd', 'h', 'a', 's', 'ss', 'ts'];
                $cameras = [
                    [1, 60, 110, 'f'],
                    [10, 100, 400, 'd'],
                    [10, 40, 200, 'h'],
                    [1, -15, 0, 'a'],
                    [0.05, 0, 1, 's'],
                    [0.1, 1, 10, 'ss'],
                    [0.1, 1, 2, 'ts']
                ];
                $allowed_values = [
                    'f' => [],
                    'd' => [],
                    'h' => [],
                    'a' => [],
                    's' => [],
                    'ss' => [],
                    'ts' => []
                ];

                foreach ($cameras as $camera) {
                    $values = [];
                    for ($i = $camera[1]; $i < $camera[2] + $camera[0]; $i += $camera[0]) array_push($allowed_values[$camera[3]], $i);
                }

                foreach ($posts as $post) {
                    if (isset($_POST[$post])) {
                        !filter_var($_POST[$post], FILTER_VALIDATE_FLOAT) ? $they_fckt_with_code = true : "";
                        if (!$they_fckt_with_code) {
                            if (array_search((float)$post, $allowed_values[$post])) ;
                        }
                    } else {
                        $they_fckt_with_code = true;
                    }
                }

                if (!$they_fckt_with_code) {
                    if (isset($_POST['cs'])) {
                        $cs = 1;
                    } else {
                        $cs = 0;
                    }

                    $loading = true;
                    $result = $model->update_camera_settings($GLOBALS['user_info']->global_id, $cs, $_POST['f'], $_POST['d'], $_POST['h'], $_POST['a'], $_POST['s'], $_POST['ss'], $_POST['ts']);
                    $uri = $GLOBALS['request_uri'] . "profile";
                    if ($result) header("location: $uri");
                }
            } elseif (isset($_FILES['avatar'])) {
                $not_ok = false;
                $target_file = basename($_FILES["avatar"]["name"]);
                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if (getimagesize($_FILES["avatar"]["tmp_name"])) $not_ok = "file not img";
                if ($_FILES["avatar"]["size"] > 500000) $not_ok = "file_size";
                if ($file_type != 'jpg' || $file_type != 'png' || $file_type != 'gif') $not_ok = "file type";

                if ($not_ok) {
                    $result = $model->update_avatar($_SESSION['ssid'], $_FILES);
                    $uri = $GLOBALS['request_uri'] . "profile";
                    if ($result) header("location: $uri");
                } else {
                    echo "$not_ok";
                }
            }
        } elseif ($routes[0] == 'settings') {
            if (isset($_SESSION['valid_user'])) {
                if (isset($_POST['submit_settings'])) {
                    if (isset($_POST['usern'])) {
                        $usern = filter_var($_POST['usern'], FILTER_SANITIZE_STRING);
                        if (!empty($usern)) {
                            $result = $model->update_username($usern);
                            if ($result) {
                                $error = 'success';
                            }
                        }

                        if ($error = 'success') $error_msg = 'Settings updated succesfully.';
                    }
                }
            }
        } elseif ($routes[0] == 'validate') {
            if (isset($_POST['submit_validate'])) {
                if (isset($_POST['passw_validate'])) {
                    if ($model->validate_user($_SESSION['ssid'], $_POST['passw_validate'])) {
                        $_SESSION['valid_user'] = "hello there";
                        $uri = $GLOBALS['request_uri'] .= 'settings';
                        header("location: $uri");
                    } else {
                        $error_msg = "Incorrect password.";
                    }
                }
            }
        } elseif ($routes[0] == 'reset') {
            if (isset($_GET['ssid'], $_GET['global_id'], $_GET['usern'])) {
                $ssid = filter_var($_GET['ssid'], FILTER_SANITIZE_STRING);
                $global_id = filter_var($_GET['global_id'], FILTER_SANITIZE_STRING);
                $usern = filter_var($_GET['usern'], FILTER_SANITIZE_STRING);

                $users_exist = $model->check_forgot_passw($ssid, $global_id, $usern);
            } else {
                header("location: ./");
            }
        }

        if ($error_msg && !$error) $error = 'error'; // If there is a error create a error class for output

        // ------------------ Include the needed page ------------------

        $folder = '../private/views/';

        if ($routes[0] == 'inspect') {
            $template = 'inspect.php';
            if (isset($routes[1])) {
                $profile = $model->get_profile($routes[1]);
                if ($profile) $profile_settings = $model->get_user_camera($profile->global_id);
            }
        } else {
            $views_files = scandir($folder);
            $views_options = array();

            foreach ($views_files as $view) {
                if ($view != 'header.php' && $view != 'footer.php' && $view != 'page404.php') array_push($views_options, explode('.php', $view)[0]);
            }

            if (!in_array($routes[0], $views_options)) {
                $template = 'page404.php';
            } else {
                $template = $views_options[array_search($routes[0], $views_options)] . '.php';
            }
        }

        echo "<script type='text/javascript'>var current_page = '".$routes[0]."';</script>";

        require $folder . "header.php";
        echo "<main>";
        include $folder . $template;
        echo "</main>";

        require $folder . "footer.php";
    }
}