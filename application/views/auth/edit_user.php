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

<?php echo form_open(uri_string(),$form_attributes);?>
<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<p>
    <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
    <?php echo form_input($first_name);?>
</p>

<p>
    <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
    <?php echo form_input($last_name);?>
</p>

<p>
    <?php echo lang('edit_user_location_label', 'company');?> <br />
    <?php echo form_dropdown('office_location',$officeLocations,$edit_user_location,$dropdown_attributes);?>
</p>

<p>
    <?php echo lang('edit_user_password_label', 'password');?> <br />
    <?php echo form_input($password);?>
</p>

<p>
    <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
    <?php echo form_input($password_confirm);?>
</p>

<h3><?php echo lang('edit_user_groups_heading');?></h3>
<?php foreach ($groups as $group):?>
    <label class="checkbox">
        <?php
        $gID=$group['id'];
        $checked = null;
        $item = null;
        foreach($currentGroups as $grp) {
            if ($gID == $grp->id) {
                $checked= ' checked="checked"';
                break;
            }
        }
        ?>
        <input type="radio" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
        <?php echo $group['name'];?>
    </label>
<?php endforeach?>

<?php echo form_hidden('id', $user->id);?>
<?php echo form_hidden($csrf); ?>

<p><?php echo form_submit($submit_btn_attributes,lang('edit_user_submit_btn'));?>
    <a href="<?php echo base_url();?>auth/"><?php echo form_button($return_btn_attributes);?></a>
</p>

<?php echo form_close();?>
</body>