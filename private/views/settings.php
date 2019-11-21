<?php

if (!isset($error_msg)) {
    $error_msg = '';
    $error = '';
}

?>

<div class="form_happy">
    <?=$GLOBALS['request_uri']?>
    <form action="<?=$GLOBALS['request_uri']?>settings" method="POST">
        <h1>Settings</h1>
        <div class="response_message <?=$error?>">
            <h2><?=$error_msg?></h2>
        </div>
        <h3>New username</h3>
        <input type="text" name="usern" class="inp_open">
        <h3>New password</h3>
        <input type="password" name="passw" class="inp_open">
        <h3>Repeat password</h3>
        <input type="password" name="repeat" class="inp_open">
        <button type="submit" class="btn_active" name="submit_settings">update settings</button>
    </form>
</div>