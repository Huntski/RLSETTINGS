<div class="profile_box">
    <div class="profile" style="cursor: default !important;">
        <img src="<?=$GLOBALS['uri']?>img/avatars/<?=$profile->avatar?>" alt=" ">
    </div>
    <h1><?=$profile->usern?></h1>
</div>

<div class="profile_inspect_form">

    <form class="camera_form inspect_form">
        <div class="setting">
            <h4>Camera shake</h4>
            <input type="checkbox" id="camerashake" <?php if ($profile_settings['cs']) echo 'checked';?>>
            <label for="camerashake" class="camerashake_label"><p>&#10003;</p></label>
        </div>
        <?php

        /*
            Camera settings:
                First value: Name of setting
                Second value: How many steps
                Third value: Lowest value
                Fourth value: Highest value
                Fifth value: Class name
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
            array_push($camera_settings[$i], $profile_settings[$camera_settings[$i][4]]);
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