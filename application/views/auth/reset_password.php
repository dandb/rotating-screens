<html>
<head>
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/auth.css" />
</head>
<body>

<div class="reset_password_container">
<h1><?php echo lang('reset_password_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>
<?php echo form_open('auth/reset_password/' . $code);?>

	<p>
		<?php echo form_input($new_password);?>
	</p>

	<p>
		<?php echo form_input($new_password_confirm);?>
	</p>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	<p><?php echo form_submit($submit_btn_attributes, lang('reset_password_submit_btn'));?></p>

<?php echo form_close();?>
</div>
</body>
</html>