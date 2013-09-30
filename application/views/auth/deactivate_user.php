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


<?php echo form_open("auth/deactivate/".$user->id,$form_attributes);?>
  <h1><?php echo lang('deactivate_heading');?></h1>
  <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
  <p class="deactiveuser-radiobutton">
  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    <input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    <input type="radio" name="confirm" value="no" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p><?php echo form_submit($submit_btn_attributes,'submit', lang('deactivate_submit_btn'));?></p>

<?php echo form_close();?>
</body>