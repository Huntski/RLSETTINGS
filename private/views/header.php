<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RLSETTINGS</title>
    <link rel="stylesheet" href="<?=$GLOBALS['uri']?>css/style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

    <header>
        <h1 onclick="request('home')">RLSETTINGS<div class="loading" style="<?php if (!$loading) echo "display: none;";?>"></div></h1>

        <?php
        if (isset($_SESSION['ssid'])) :
            if (isset($GLOBALS['user_info'])) : ?>

                <div class="profile" onclick="request('profile')">
                    <img src="<?=$GLOBALS['uri']?>img/avatars/<?=$GLOBALS['user_info']->avatar?>" alt=" ">
                </div>

            <?php endif;
            else : ?>

            <button onclick="request('login')" class="btn_active">login</button>

    <?php endif; ?>
        </header>
