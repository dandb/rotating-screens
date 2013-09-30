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


<?php echo form_open("auth/create_user",$form_attributes);?>
<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>
<div id="infoMessage" class="error_message"><?php echo $message;?></div>
<p>
    <?php echo lang('create_user_fname_label', 'first_name');?> <br />
    <?php echo form_input($first_name);?>
</p>

<p>
    <?php echo lang('create_user_lname_label', 'first_name');?> <br />
    <?php echo form_input($last_name);?>
</p>

<p>
    <?php echo lang('create_user_office_location', 'company');?> <br />
    <?php echo form_dropdown('office_location',$officeLocations,'1',$dropdown_attributes);?>
</p>

<p>
    <?php echo lang('create_user_email_label', 'email');?> <br />
    <?php echo form_input($email);?>
</p>

<p>
    <?php echo lang('create_user_password_label', 'password');?> <br />
    <?php echo form_input($password);?>
</p>

<p>
    <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
    <?php echo form_input($password_confirm);?>
</p>


<p><?php echo form_submit($submit_btn_attributes,'Submit', lang('create_user_submit_btn'));?></p>

<?php echo form_close();?>
</body>