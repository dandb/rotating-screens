<head>
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/auth.css" />
</head>

<body class="forgotpassword_body">
<?php echo form_open("auth/forgot_password",$form_attributes);?>
    <h1 style="color: white; margin-left: 0px;"><?php echo lang('forgot_password_heading');?></h1>

    <p><?php echo form_input($email);?></p>
    <p><?php echo form_submit($submit_btn_attributes, lang('forgot_password_submit_btn'));?>
        <a href="<?php echo base_url();?>auth/login"><?php echo form_button($return_btn_attributes);?></a>
    </p>
    <div id="infoMessage" class="error_message"><?php echo $message;?></div>
<?php echo form_close();?>
</body>