<?php

if (!isset($error_msg)) {
    $error_msg = '';
    $error = '';
}

?>

<div class="form_happy forgot">
    <h1>Forgot password? Wow.</h1>
    <p>Please enter your email and we'll send u instructions on how to reset your password.</p>
    <div class="response_message <?=$error?>">
        <h2><?=$error_msg?></h2>
    </div>
    <form action="<?=$GLOBALS['request_uri']?>forgot">
        <h3>Email</h3>
        <input type="email" class="inp_open" name="email">
        <p>Make sure email is correct.</p>
        <button onclick="submitForm" name="forgot_submit" class="btn_active">send email</button>
    </form>
</div>