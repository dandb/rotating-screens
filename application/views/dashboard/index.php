<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aburks
 * Date: 9/16/13
 * Time: 4:04 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<html>
<head>
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/dashboard.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/header.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url();?>public/js/dashboard.js"></script>
    <script src="<?php echo base_url();?>public/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>public/js/jquery.tablednd.js"></script>
</head>

<body>

<?php
    $headerData['isAdmin']=$isAdmin;
    $headerData['userId']=$userId;
    $this->load->view('partials/header',$headerData);
?>

<div id="to_top_btn"><a href="#"><img src="<?php echo base_url();?>public/images/to_top_icon.png" width="75px" height="75px" /></a></div>

<div class="container">
    <div class="error_message" id="validate_url"><?php echo $message;?></div>
    <div class="start_dashboard_container">
        <a id="start_dashboard_btn" href="#" class="btn btn-default btn-lg">Start Dashboard</a>
    </div>
     <?php //echo //$message;
    echo validation_errors();
    ?>

    <div class="panel-group" id="addEntry_container">
        <div class="panel panel-primary">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#addEntry_container" href="#add_new_entry">
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo $this->lang->line('office_'.$userOfficeLocation);?> Office: Add Entry</h4>
            </div>
            </a>
            <div id="add_new_entry" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="error_message" class="error_message"></div>
                    <?php echo form_open("dashboard/",$add_form_attributes);?>

                    <div class="form-group"><?php echo form_dropdown('add_category',$add_category,$add_select_category,$add_category_attribute);?></div>
                    <div class="form-group"><?php echo form_input($add_description);?></div>
                    <div class="form-group">
                        <?php echo form_input($add_website);?>
                        <?php echo form_input($add_twitter);?>
                        <?php echo form_input($add_youtube);?>
                    </div>
                    <div class="form-group"><?php echo form_input($add_time_interval);?></div>

                    <div class="form-group" id ="add_message_div_container"><?php echo form_textarea($add_message);?></div>


                    <div class="form-group"><?php echo form_submit($add_submit_btn_attributes,'Add Entry');?></div>


                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>

    <table id="dashboard_table" class="dashboard_table" data-locationid="<?php echo $userOfficeLocation;?>">
        <thead>
        <tr class="dashboard_header" id="dashboard_location_<?php echo $userOfficeLocation;?>">
            <th class="id_col" style="display: none;">ID</th>
            <th class="category_col"></th>
            <th class="url_col"></th>
            <th class="description_col">Description</th>
            <th class="timeInterval_col" style="width: 50px;">Time</th>
            <th class="edit_col"></th>
            <th class="delete_col"></th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($dashboardEntries)){
            for($i=1;$i<=count($dashboardEntries);$i++){
            $row = $dashboardEntries[$i-1];
            //set User-friendly category and twitter Keyword
            if ($row['category_id'] == 1){
                $category="Website";
            } else if ($row['category_id'] == 2){
                $category="Twitter";
                $row['URL'] =str_replace($this->lang->line('twitter_baseSearchURL'),"",$row['URL']);
                $row['URL'] =str_replace("%40","@",$row['URL']);
                $row['URL'] =str_replace("%20"," ",$row['URL']);
                $row['URL'] =str_replace("%23","#",$row['URL']);
            } else if($row['category_id'] == 3){
                $category="Youtube";
            } else if($row['category_id'] == 4){
                $category="Message";
            }
        ?>
            <tr id ="<?php echo $row['dashboard_id'];?>" class="dashboard_row" data-sortid="<?php echo $row['sort_id'];?>">

                <td id="dashboardId<?php echo $row['dashboard_id'];?>" class="id_col" data-entryid="<?php echo $row['dashboard_id'];?>" style="display: none;"><?php echo $row['dashboard_id'];?></td>

                <td id="categoryId<?php echo $row['dashboard_id'];?>" class="category_col" data-entryid="<?php echo $row['dashboard_id'];?>">
                    <div class="<?php echo strtolower($category);?>_label"><?php echo $category;?></div>
                </td>

                <td id="URL<?php echo $row['dashboard_id'];?>" class="url_col" data-entryid="<?php echo $row['dashboard_id'];?>">
                    <?php

                    if (strcmp($category, "Message") == 0) {

                        echo "<span><a href='". base_url()  ."dashboard/message/". $row['dashboard_id'] ."' target='_blank'>Preview Message</a></span><span style='display:none;' id='message". $row['dashboard_id'] ."'>". $row['message']."</span>";
                    } else {
                        echo $row['URL'];
                    }

?>
                </td>

                <td id="description<?php echo $row['dashboard_id'];?>" class="description_col" data-entryid="<?php echo $row['dashboard_id'];?>">
                    <?php
                    $row['description'] = str_replace("%20"," ",$row['description']);
                    $row['description'] = str_replace("%40","@",$row['description']);
                    $row['description'] = str_replace("%26","&",$row['description']);
                    $row['description'] = str_replace("%23","#",$row['description']);

                    echo $row['description'];?>
                </td>

                <td id="time_interval<?php echo $row['dashboard_id'];?>" class="timeInterval_col" data-entryid="<?php echo $row['dashboard_id'];?>"><?php echo $row['time_interval'];?></td>

                <td id="edit<?php echo $row['dashboard_id'];?>" class="edit_col" data-entryid="<?php echo $row['dashboard_id'];?>" id="edit<?php echo $row['dashboard_id'];?>">
                    <a data-toggle="modal" href="#editEntry-modal" class="edit_entry">
                        <img src="<?php echo base_url();?>public/images/edit_icon.png" width="20px" height="24px" />
                    </a></td>

                <td id="delete<?php echo $row['dashboard_id'];?>" class="delete_col" data-entryid="<?php echo $row['dashboard_id'];?>" id="delete<?php echo $row['dashboard_id'];?>">
                    <a href="#" class="delete_entry">
                        <img src="<?php echo base_url();?>public/images/delete_icon.png" width="25px" height="25px" />
                    </a></td>
            </tr>

        <?php }}?>
        </tbody>
    </table>



    <!-- Edit Entry Modal -->
    <div class="modal fade" id="editEntry-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit Form:</h4>
                </div>
                <div class="modal-body">
                    <div id="error_message_edit" class="error_message"></div>
                    <div id="edit_DashboardId" style="display:none;"></div>
                    <?php echo form_open("",$edit_form_attributes);?>
                        <div class="form-group"><?php echo form_dropdown('edit_category',$edit_category,'1',$edit_category_attribute);?></div>
                        <div class="form-group"><?php echo form_input($edit_description);?></div>
                        <div class="form-group">
                            <?php echo form_input($edit_website);?>
                            <?php echo form_input($edit_twitter);?>
                            <?php echo form_input($edit_youtube);?>
                            <?php echo form_textarea($edit_message);?>
                        </div>
                        <div class="form-group"><?php echo form_input($edit_time_interval);?></div>
                    <?php echo form_close();?>
                </div>

                <div class="modal-footer">
                    <div id="edit_loading"><img src="<?php echo base_url();?>public/images/edit_loading_icon.gif"/></div>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="edit_entry_close">Close</button>
                    <button type="button" class="btn btn-default btn-primary" id="edit_entry_btn">Edit Entry</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loading-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content loading-div">
                <div class="modal-body">
                    <img src="<?php echo base_url();?>public/images/loading_icon"/>
                </div>


            </div>
        </div>
    </div>


</div>

</body>
</html>