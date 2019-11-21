<?php

if (!isset($error_msg)) {
    $error_msg = '';
    $error = '';
}

?>

<div class="form_happy reset">
    <h1>Reset password.</h1>
    <p>Please enter a new password.</p>
    <div class="response_message <?=$error?>">
        <h2><?=$error_msg?></h2>
    </div>
    <form action="<?=$GLOBALS['request_uri']?>reset">
        <h3>New password.</h3>
        <input type="password" class="inp_open" name="passw">
        <h3>Repeat new password.</h3>
        <input type="password" class="inp_open" name="repeat">
        <button onclick="submitForm" name="reset_submit" class="btn_active">send email</button>
    </form>
</div>