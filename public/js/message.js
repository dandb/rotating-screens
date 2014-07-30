$(document).ready(function()
{
    $("body").click(function(){
        console.log(CKEDITOR.instances.test.getData());
        $("#message_container").html(CKEDITOR.instances.test.getData());
    });

});