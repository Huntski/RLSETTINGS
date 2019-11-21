<div class="form_happy">
    <form action="<?=$GLOBALS['request_uri']?>settings" method="POST">
        <h1>Are you realy u?</h1>
        <div class="response_message <?=$error?>">
            <h2><?=$error_msg?></h2>
        </div>

        <h3>Password</h3>
        <input type="password" maxlength="40" minlength="3" name="passw_validate" autofocus class="inp_open">
        <button class="btn_active" type="submit" name="submit_validate">validate user</button>
    </form>
</div>