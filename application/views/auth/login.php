<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/auth.css" />
</head>
<body class="signin_body">

        <div class="signin_container" style="margin-top: 115px;">

        <?php echo form_open("auth/login",$form_attributes);?>
            <img src="<?php echo base_url();?>public/images/logo.jpg" width="150px" style="margin: 0 0 10px 150px;"/>

            <?php echo form_input($identity);?>
            <?php echo form_input($password);?>
            <a href="forgot_password"><div class="forgot_password_link" id="forgot_password">?</div></a>


        <p><?php echo form_submit($submit_btn_attributes,lang('login_submit_btn'));?></p>
        <?php echo form_close();?>

            <div id="infoMessage" class="infoMessage" style="margin-left: 25px; margin-bottom: 5px;"><?php echo $message;?></div>
        </div>


</body>
</html>