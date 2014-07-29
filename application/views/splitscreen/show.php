<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aburks
 * Date: 9/16/13
 * Time: 4:04 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<html>
<head>
    <title>Split screens</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/splitscreen.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/header.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/js/splitscreen.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap.js"></script>
</head>


<body>



<div class="wrapper">
    <?php

    foreach ($listOfUrls as $eachScreen) {
        //        var_dump($eachScreen['created_on']);
        if ($eachScreen['screen'] == 1 || $eachScreen['screen'] == 4) {
            echo "<div class='container_row'>";
        }
        ?>
        <div id="container<?php echo $eachScreen['screen']?>" class="oddDiv iframe_container">
            <iframe id="frame<?php echo $eachScreen['screen']?>" class="frame3x3"
                    src="<?php echo trim($eachScreen['url'])?>"></iframe>
        </div>

        <?php

        if ($eachScreen['screen'] == 3 || $eachScreen['screen'] == 6) {
            echo "</div>";
        }
    } ?>

</div>


</body>

</html>
