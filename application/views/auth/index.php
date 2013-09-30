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

<div class="all-users">
<h1><?php echo lang('index_heading');?></h1>
<p><?php echo lang('index_subheading');?></p>

<div id="infoMessage" class="successMessage"><?php echo $message;?></div>

<table class="table-striped">
    <thead>
	<tr class="header-row">
		<th class="table-col"><?php echo lang('index_fname_th');?></th>
		<th class="table-col"><?php echo lang('index_lname_th');?></th>
		<th class="table-col email-col"><?php echo lang('index_email_th');?></th>
		<th class="table-col"><?php echo lang('index_location_th');?></th>
		<th class="table-col"><?php echo lang('index_groups_th');?></th>
		<th class="table-col"><?php echo lang('index_status_th');?></th>
		<th class="table-col"><?php echo lang('index_action_th');?></th>
	</tr>
    </thead>
    <tbody>
	<?php foreach ($users as $user):?>
		<tr class="table-row">
			<td class="table-col"><?php echo $user->first_name;?></td>
			<td class="table-col"><?php echo $user->last_name;?></td>
			<td class="table-col"><?php echo $user->email;?></td>
			<td class="table-col"><?php echo lang('office_'.$user->office_location);?></td>
			<td class="table-col">
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
                <?php endforeach?>
			</td>
			<td class="table-col"><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
			<td class="table-col"><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
		</tr>

	<?php endforeach;?>
    </tbody>
</table>

<p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?>
</div>
</body>