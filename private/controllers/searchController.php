<?php

class searchController {
    public function load ($routes) {
        $model = new model;

        if (!isset($routes[1])) {
            echo "";
            exit;
        }

        $result = $model->search_user($routes[1]);

        if (!count($result)) {
            echo "nothing";
            exit;
        }

        echo json_encode($result);


    }
}