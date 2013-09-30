<head>
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/header.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/auth.css" />
</head>

<body>
<?php $this->load->view('partials/header',$userIdentity);
?>


<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/change_password",$form_attributes);?>
      <h1><?php echo lang('change_password_heading');?></h1>

      <p>
            <?php echo form_input($old_password);?>
            <?php echo form_input($new_password);?>
            <?php echo form_input($new_password_confirm);?>
      </p>

      <?php echo form_input($user_id);?>

      <p><?php echo form_submit($submit_btn_attributes, lang('forgot_password_submit_btn'));?>
        <a href="<?php echo base_url();?>auth/"><?php echo form_button($return_btn_attributes);?></a>
      </p>

<?php echo form_close();?>
</body>