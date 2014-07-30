<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aburks
 * Date: 7/29/14
 * Time: 3:45 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<html>
<head>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url();?>public/js/message.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/custom-message.css" />

</head>

<body>
<div id="message_container">

        <?php echo $message;?>
</div>

</body>
