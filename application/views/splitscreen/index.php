<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aburks
 * Date: 6/26/14
 * Time: 12:22 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<html>
<head>
    <title>Split Screen</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/splitscreen.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/header.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/js/splitscreen.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap.js"></script>
</head>

<body>
<div class="wrapper">

<div class="split_screen_container">
    <form id="split_screen_form" class="form-inline">
        <?php

        foreach ($listOfUrls as $eachScreen) {
        //        var_dump($eachScreen['created_on']);
        if ($eachScreen['screen'] == 1 || $eachScreen['screen'] == 4) {
            echo "<div class='split_screen_row'>";
        }
        ?>
            <div class="split_screen_div">
                <h4>Screen <?php echo $eachScreen['screen']?></h4>
                <textarea cols="45" rows="7" name="screen<?php
                echo $eachScreen['screen']?>" id="screen<?php
                echo $eachScreen['screen']?>_url" class="form-control" form="split_screen_form"><?php echo trim($eachScreen['url'])?></textarea>
            </div>

            <?php

            if ($eachScreen['screen'] == 3 || $eachScreen['screen'] == 6) {
                echo "</div>";
            }
        } ?>

        <input type="button" class="btn btn-default btn-primary" name="split_screen_submit" id="split_screen_submit" value="Submit">
    </form>
</div>

</div>

</body>
