<?php

class templateController {
    public function load ($routes) {

        $model = new model;

        if ($routes[1] == 'inspect') {
            $template = 'inspect.php';
            if (isset($routes[2])) {
                $profile = $model->get_profile($routes[2]);
                if ($profile) $profile_settings = $model->get_user_camera($profile->global_id);
            }
        } else {

            $views_files = scandir('../private/views/');
            $views_options = array();

            foreach ($views_files as $view) {
                if ($view != 'header.php' && $view != 'footer.php' && $view != 'page404.php') array_push($views_options, explode('.php', $view)[0]);
            }

            if (!in_array($routes[1], $views_options)) {
                $template = 'page404.php';
            } else {
                $template = $views_options[array_search($routes[1], $views_options)] . '.php';
            }
        }

        include '../private/views/' . $template;
    }
}