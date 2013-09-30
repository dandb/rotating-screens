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
<?php echo form_open(current_url(),$form_attributes);?>
      <h1><?php echo lang('edit_group_heading');?></h1>
      <p><?php echo lang('edit_group_subheading');?></p>

      <div id="infoMessage"><?php echo $message;?></div>

      <p>
            <?php echo lang('create_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

      <p><?php echo form_submit($submit_btn_attributes, lang('edit_group_submit_btn'));?>
          <a href="<?php echo base_url();?>auth/"><?php echo form_button($return_btn_attributes);?></a>
      </p>

<?php echo form_close();?>
</body>