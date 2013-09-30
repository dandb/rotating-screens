
<img class="logo_header" src="<?php echo base_url();?>public/images/logo.jpg"/>

<div id="header" class="account_dropdown" style="<?php if($isAdmin == 1){echo "top:-120px;";} else {echo "top:-90px;";}?>">


    <div class="dropdown_option"><a href="<?php echo base_url();?>dashboard">My Dashboard</a></div>

    <?php
        if($isAdmin == 1){
            echo "<div class='dropdown_option'><a href='".base_url()."auth'>Manage Users</a></div>";
        }
    ?>

    <div class="dropdown_option"><a href="<?php echo base_url();?>auth/change_password">Change Password</a></div>
    <div class="dropdown_option"><a href="<?php echo base_url();?>auth/logout">Logout</a></div>
    <div id="manage_dropdown" data-admin="<?php echo $isAdmin;?>">Manage Account</div>

</div>

<script>
    $('.account_dropdown').mouseover(function(){
        $('.account_dropdown').css("top","0px");
    });

    $('.account_dropdown').mouseout(function(){
        if($('#manage_dropdown').data('admin')){
            $('.account_dropdown').css("top","-120px");
        } else {
            $('.account_dropdown').css("top","-90px");
        }
    });
</script>