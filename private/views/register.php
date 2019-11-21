<?php

if (!isset($error_msg)) {
    $error_msg = '';
    $error = '';
}

?>

<div class="form_happy register">
    <h1>Register</h1>
    <p>Create a account to save and share your own <br>rocket league camera settings.</p>
    <div class="response_message <?=$error?>">
        <h2><?=$error_msg?></h2>
    </div>
    <form action="<?=$GLOBALS['request_uri']?>register" method="POST">
        <h3>Email</h3>
        <input type="email" class="inp_open" name="r_email" autofocus value="<?php if (isset($_POST['r_email'])) echo $_POST['r_email']; ?>">
        <h3>Password</h3>
        <input type="password" class="inp_open" name="r_passw" value="<?php if (isset($_POST['r_passw']) )echo $_POST['r_passw']; ?>">
        <h3>Username</h3>
        <input type="text" class="inp_open" name="r_usern" value="<?php if (isset($_POST['r_usern'])) echo $_POST['r_usern']; ?>">
        <p>Already have account? <span class="link" onclick="request('login')">Login <span class="orange">here</span></p>
        <button class="btn_active" name="register_submit">register to rlsettings</button>
    </form>
</div>