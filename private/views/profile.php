<div class="check_container">
    <h2>Edit</h2>
    <input type="checkbox" id="edit">
    <label for="edit" class="checkbox_label"><div></div></label>
</div>

<div class="profile_box">
    <form class="avatar_form" action="<?=$GLOBALS['request_uri']?>profile" method="POST" enctype="multipart/form-data" style="display: none;">
        <input type="file" id="update_avatar" name="avatar" class="avatar_file">
    </form>
    <label for="update_avatar" class="avatar_label">
        <div class="profile">
            <img src="<?=$GLOBALS['uri']?>img/avatars/<?=$GLOBALS['user_info']->avatar?>" alt=" ">
        </div>
    </label>
    <h1><?=$GLOBALS['user_info']->usern?></h1>
    <h2 class="orange" onclick="request('settings')">Settings</h2>
    <a href="<?=$GLOBALS['request_uri']?>logout"><h2 class="orange">logout</h2></a>
</div>

<div class="profile_settings">

    <form action="<?=$GLOBALS['request_uri']?>profile" method="POST" class="camera_form edit_form" style="display: none" >
        <div class="setting">
            <h4>Camera shake</h4>
            <input name="cs" type="checkbox" id="camerashake" <?php if ($GLOBALS['user_camera']['cs']) echo 'checked';?>>
            <label name="cs" for="camerashake" class="camerashake_label"><p>&#10003;</p></label>
        </div>
        <?php
        /*
            Camera settings:
                First value: Name of setting
                Second value: How many steps
                Third value: Lowest value
                Fourth value: Highest value
                Fifth value: Class name
                Sixth value: Users camera settings
        */

        $camera_settings = array(
            array('fov', 1, 60, 110, 'f'),
            array('distance', 10, 100, 400, 'd'),
            array('height', 10, 40, 200, 'h'),
            array('angle', 1, -15, 0, 'a'),
            array('stiffness', 0.05, 0, 1, 's'),
            array('swivelspeed', 0.1, 1, 10, 'ss'),
            array('transition speed', 0.1, 1, 2, 'ts')
        );
        for ($i = 0; $i < count($camera_settings); $i++) {
            array_push($camera_settings[$i], $GLOBALS['user_camera'][$camera_settings[$i][4]]);
        }

        foreach ($camera_settings as $setting) :
            ?>
            <div class="setting">
                <h4><?=$setting[0]?></h4>
                <input type="range" name="<?=$setting[4]?>" min="<?=$setting[2]?>" max="<?=$setting[3]?>" step="<?=$setting[1]?>" class="<?=$setting[4]?>_range" value="<?=$setting[5]?>">
                <h4 class="<?=$setting[4]?>_output"></h4>
            </div>
            <?php
        endforeach;
        ?>

        <button type="submit" name="camera_submit" class="btn_active">update camera</button>
    </form>

    <form class="camera_form inspect_form">
        <div class="setting">
            <h4>Camera shake</h4>
            <input type="checkbox" id="camerashake" <?php if ($GLOBALS['user_camera']['cs']) echo 'checked';?>>
            <label for="camerashake" class="camerashake_label"><p>&#10003;</p></label>
        </div>
        <?php

        /*
            Camera settings:
                First value: Name of setting
                Second value: How many steps
                Third value: Lowest value
                Fourth value: Highest value
                Fifth value: Class names
                Sixth value: Users camera settings (Later added in for loop)
        */

        $camera_settings = array(
            array('fov', 1, 60, 110, 'f'),
            array('distance', 10, 100, 400, 'd'),
            array('height', 10, 40, 200, 'h'),
            array('angle', 1, -15, 0, 'a'),
            array('stiffness', 0.05, 0, 1, 's'),
            array('swivelspeed', 0.1, 1, 10, 'ss'),
            array('transition speed', 0.1, 1, 2, 'ts')
        );
        for ($i = 0; $i < count($camera_settings); $i++) {
            array_push($camera_settings[$i], $GLOBALS['user_camera'][$camera_settings[$i][4]]);
        }

        foreach ($camera_settings as $setting) :
            ?>
            <div class="setting">
                <h4><?=$setting[0]?></h4>
                <input type="range" min="<?=$setting[2]?>" max="<?=$setting[3]?>" step="<?=$setting[1]?>" class="<?=$setting[4]?>_range" value="<?=$setting[5]?>">
                <h4><?=number_format((float)$setting[5], 2, '.', '')?></h4>
            </div>
            <?php
        endforeach;
        ?>
    </form>
</div>