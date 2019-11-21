<?php

if (!isset($error_msg)) {
    $error_msg = '';
    $error = '';
}

?>

<div class="form_happy login">
    <h1>Welcome back!?</h1>
    <p>Login to edit and share<br>your settings.</p>
    <div class="response_message <?=$error?>">
        <h2><?=$error_msg?></h2>
    </div>
    <form action="<?=$GLOBALS['request_uri']?>login" method="POST">
        <h3>Email</h3>
        <input type="email" class="inp_open" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" autofocus>
        <h3>Password</h3>
        <input type="password" class="inp_open" name="passw" value="<?php if (isset($_POST['passw'])) echo $_POST['passw']; ?>">
        <p>Forgot password? <span class="link" onclick="request('forgot')">Click <span class="orange">here</span></span><br>
        Don't have account? <span class="link" onclick="request('register')">Regsiter <span class="orange">here</span></span></p>
        <button class="btn_active" name="login_submit">login to rlsettings</button>
    </form>
</div>