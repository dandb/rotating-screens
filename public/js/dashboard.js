$(document).ready(function()
{
    $("#add_website").show();
    $("#add_twitter").hide();
    $("#add_youtube").hide();
    setTimeout(function(){$("#validate_url").fadeOut(1000);},5000);
    $("#dashboard_table").tableDnD();

    $('#to_top_btn').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 700);
    });

    $(window).scroll(function(){
        if ($(this).scrollTop() > 75) {
            $('#to_top_btn').fadeIn();
        } else {
            $('#to_top_btn').fadeOut();
        }
    });

    $("#start_dashboard_btn").click(function(){
        $.ajax({
            url:"/dashboard/returningCurrentURLsAndTimeIntervalsAndDescriptions/",
            success:function(data){
                data = JSON.parse(data);
                var arrayOfURLs = data.urls;
                var arrayOfTimeIntervals = data.times;
                var arrayOfDescriptions = data.descriptions;
                var arrayOfDashboardIds = data.dashboard_ids;

                var newWindow = window.open("http://www.dandb.com/","",'height=800,width=1200');
                var i = 0;

                function displayURLs() {
                    newWindow.location.href=arrayOfURLs[i];
                    setTimeout(displayWebsites, arrayOfTimeIntervals[i]*1000);
                    i++;
                    if(i>=arrayOfURLs.length) {i=0;}
                }

                function displayWebsites() {
                    var cover_url = "dashboard/cover/" + arrayOfDashboardIds[i];
                    newWindow.location.href= cover_url;
                    setTimeout(displayURLs, 5000);
                }

                displayWebsites();
           }
        });
    });

    $('.dashboard_table').tableDnD({
        //get order of table after dropping
        //comparing new location
        onDrop: function(table, row)
        {
            var selected_row_order_after = (("&"+$.tableDnD.serialize()).split("&dashboard_table[]="));
            selected_row_order_after.splice(0,2); //removing first unnecessary two indexes
            $.ajax({
                type: "POST",
                url:"/dashboard/change_order/",
                data: {arrayOfDashboardEntries: selected_row_order_after},
                success:function(data){
                    //something happens here
                }
            });
        }
    });

    $('.delete_entry').click(function(event)
    {
        if (confirm('Are you sure you want to delete?')) {
            var deleteID = $(this).parent().data('entryid');
            $.ajax({
                type: "POST",
                url:"/dashboard/delete/",
                data: {dashboardID: deleteID},
                success:function(data){
                    $('#'+deleteID).remove();
                }
            });
        }
    });

    //edit modal
    $('.edit_entry').click(function(event)
    {
        $("#error_message_edit").hide();
        $("#edit_loading").hide();
        var editID = $(this).parent().data('entryid');

        $("#edit_description").val($("#description"+editID).text().trim());
        $("#edit_DashboardId").html(editID);
        $("#edit_time-interval").val($("#time_interval"+editID).text());

        if($("#categoryId"+editID).children().text() =="Website"){
            $("#edit_website").val($("#URL"+editID).text().trim());
            $('#edit_category').val('1');
            $("#edit_website").show();
            $("#edit_twitter").hide();
            $("#edit_youtube").hide();
        } else if($("#categoryId"+editID).children().text() =="Twitter"){
            $("#edit_twitter").val(($("#URL"+editID).text().trim()));
            $('#edit_category').val('2');
            $("#edit_website").hide();
            $("#edit_twitter").show();
            $("#edit_youtube").hide();
        } else if($("#categoryId"+editID).children().text() =="Youtube"){
            $("#edit_youtube").val($("#URL"+editID).text().trim());
            $('#edit_category').val('3');
            $("#edit_website").hide();
            $("#edit_twitter").hide();
            $("#edit_youtube").show();
        }
    });

    $("#edit_category").change(function()
    {
        if($("#edit_category").val() ==1){
            $("#edit_website").show();
            $("#edit_twitter").hide();
            $("#edit_youtube").hide();
        }
        else if ($("#edit_category").val() == 2){
            $("#edit_website").hide();
            $("#edit_twitter").show();
            $("#edit_youtube").hide();
        }
        else if ($("#edit_category").val() == 3){
            $("#edit_website").hide();
            $("#edit_twitter").hide();
            $("#edit_youtube").show();
        }
    });


    $("#edit_entry_btn").click(function(e)
    {

        if(validateEditEntryForm()){

            var edit_dashboardId = $("#edit_DashboardId").text();
            var edit_description = $("#edit_description").val();
            var edit_time_interval  = $("#edit_time-interval").val();

            if($("#edit_category").val() ==1){
                var edit_category = 1;
                var edit_URL = $("#edit_website").val();
            }
            else if ($("#edit_category").val() == 2){
                var edit_category = 2;
                var twitterKeyword =  $("#edit_twitter").val();
                //modifying twitter keyword
                twitterKeyword = twitterKeyword.replace("@","%40");
                twitterKeyword = twitterKeyword.replace(" ","%20");
                twitterKeyword = twitterKeyword.replace("#","%23");
                twitterKeyword = "https://twitter.com/search?q=" + twitterKeyword;
                var edit_URL = twitterKeyword;
            }
            else if ($("#edit_category").val() == 3){
                var edit_category = 3;
                var edit_URL = $("#edit_youtube").val();

                edit_URL += "&autoplay=1";
                edit_URL = edit_URL.replace("watch?v=","v/");
            }

            $.ajax({
                type: "POST",
                url:"/dashboard/edit/",
                data: {dashboardId: edit_dashboardId, description: edit_description, time_interval: edit_time_interval, category: edit_category, URL: edit_URL},
                success:function(data){
                    var response = $.parseJSON(data);
                    if(response == "1"){
                        $("#edit_entry_close").hide();
                        $("#edit_entry_btn").hide();
                        $("#edit_loading").show();
                        location.reload();
                    } else {
                        $("#error_message_edit").html("<p>Please enter a valid URL.</p>");

                    }
                }
            });

        } else {
            $('#editEntry-modal').modal('show');
        }


    });

    $("#edit_description").keyup(function(e){
        if(e.keyCode == 13){
            $("#edit_entry_btn").click();
        }
    });

    $("#edit_website").keyup(function(e){
        if(e.keyCode == 13){
            $("#edit_entry_btn").click();
        }
    });

    $("#edit_twitter").keyup(function(e){
        if(e.keyCode == 13){
            $("#edit_entry_btn").click();
        }
    });

    $("#edit_youtube").keyup(function(e){
        if(e.keyCode == 13){
            $("#edit_entry_btn").click();
        }
    });

    $("#edit_time-interval").keyup(function(e){
        if(e.keyCode == 13){
            $("#edit_entry_btn").click();
        }
    });

    //add modal
    $("#add_category").change(function()
    {
        if($("#add_category").val() ==1) {
            $("#add_website").show();
            $("#add_twitter").hide();
            $("#add_youtube").hide();
        }
        else if ($("#add_category").val() == 2) {
            $("#add_website").hide();
            $("#add_twitter").show();
            $("#add_youtube").hide();
        }
        else if ($("#add_category").val() == 3) {
            $("#add_website").hide();
            $("#add_twitter").hide();
            $("#add_youtube").show();
        }
    });


    $( "#addEntry_form" ).submit(function(e)
    {
        if(!validateAddEntryForm()) {
            e.preventDefault();
        } else {
            displayLoadingModal();
        }
    });

    //
    $('.dashboard_row').mouseover(function(){
        $('#'+$(this).attr('id')).css("background-color","#CEE6FF");
    });

    $('.dashboard_row').mouseout(function(){
        $('#'+$(this).attr('id')).css("background-color","#F2F7FB");
    });

    //checkboxes add form for admin
    $('#locationAll').click(function(){
        if($('#locationAll').is(':checked')){
            $('.checkbox-location_add').prop('checked', true);
        } else {
            $('.checkbox-location_add').prop('checked', false);
        }
    });


    $('.checkbox-location_add').click(function(){
        if ($("#addEntry_form input:checkbox:checked").length != 8)
        {
            $('#locationAll').prop('checked', false);
        }
    });

    function validateAddEntryForm()
    {
        var formValidated = true;
        var message="";
        //Validate Description Field
        if(!($("#add_description").val())) {
            message += "<p>The Description field is required.</p>";
            formValidated = false;
        }
        if(($("#add_description").val().length > 24)){
            message += "<p>The Description requires maximum of 24 characters.</p>";
            formValidated = false;
        }
        //Validate URL field
        if($("#add_category").val() ==1) {
            if(!($("#add_website").val())) {
                message += "<p>The Website URL field is required.</p>";
                formValidated = false;
            }
        }
        else if ($("#add_category").val() ==2) {
            if(!($("#add_twitter").val())) {
                message += "<p>The Twitter Keyword field is required.</p>";
                formValidated = false;
            }
        }
        else if ($("#add_category").val() ==3) {
            if(!($("#add_youtube").val())) {
                message += "<p>The Youtube URL field is required.</p>";
                formValidated = false;
            }
        }
        //Validate Time Interval field
        if(!($("#add_time-interval").val())) {
            message += "<p>The Time Interval field is required.</p>";
            formValidated = false;
        } else if(!(($("#add_time-interval").val()).match(/^\d+$/))) {
            message += "<p>The Time Interval field must be an integer.</p>";
            formValidated = false;
        }

        //check checkboxes only for admins
        if($("#locationAll").length){
            if ($("#addEntry_form input:checkbox:checked").length == 0){
                message += "<p>At least one location must be picked.</p>";
                formValidated = false;
            }
        }
        $("#error_message").html(message);
        return formValidated;
    }

    function validateEditEntryForm()
    {
        $("#error_message_edit").show();
        var formValidated = true;
        var message="";
        //Validate Description Field
        if(!($("#edit_description").val())) {
            message += "<p>The Description field is required.</p>";
            formValidated = false;
        }
        if(($("#edit_description").val().length > 24)){
            message += "<p>The Description requires maximum of 24 characters.</p>";
            formValidated = false;
        }
        //Validate URL field
        if($("#edit_category").val() ==1) {
            if(!($("#edit_website").val())) {
                message += "<p>The Website URL field is required.</p>";
                formValidated = false;
            }
        }
        else if ($("#edit_category").val() ==2) {
            if(!($("#edit_twitter").val())) {
                message += "<p>The Twitter Keyword field is required.</p>";
                formValidated = false;
            }
        }
        else if ($("#edit_category").val() ==3) {
            if(!($("#edit_youtube").val())) {
                message += "<p>The Youtube URL field is required.</p>";
                formValidated = false;
            }
        }
        //Validate Time Interval field
        if(!($("#edit_time-interval").val())){
            message += "<p>The Time Interval field is required.</p>";
            formValidated = false;
        } else if(!(($("#edit_time-interval").val()).match(/^\d+$/))){
            message += "<p>The Time Interval field must be an integer.</p>";
            formValidated = false;
        }
        $("#error_message_edit").html(message);
        return formValidated;
    }

    function displayLoadingModal(){
        //displaying loading-modal
        $("#loading-modal").addClass('in');
        $('body').addClass('modal-open');
        var backdropDiv = document.createElement('div');
        backdropDiv.id = 'backdrop_div';
        document.body.appendChild(backdropDiv);
        $("#loading-modal").css("display","block");
        $("#backdrop_div").addClass('modal-backdrop fade in');
    }

    function hideLoadingModal(){
        $("#loading-modal").removeClass('in');
        $('body').removeClass('modal-open');
        $("#backdrop_div").remove();
        $("#loading-modal").css("display","none");
    }
});
