$(document).ready(function()
{
    var windowHeight = $(document).height();
    var windowWidth = $(document).width();

    $(".container_row").width(windowWidth-10);
    $(".container_row").height(windowHeight/2);

    $(".iframe_container").width((windowWidth-20)/3);
    $(".iframe_container").height((windowHeight-15)/2);

    $(".frame3x3").width(windowWidth);
    $(".frame3x3").height(windowHeight+450);


    $(window).resize(function() {
        windowHeight = $(document).height();
        windowWidth = $(document).width();

        $(".container_row").width(windowWidth-10);
        $(".container_row").height(windowHeight/2);

        $(".iframe_container").width((windowWidth-20)/3);
        $(".iframe_container").height((windowHeight-15)/2);

        $(".frame3x3").width(windowWidth);
        $(".frame3x3").height(windowHeight+450);
    });

    $("#split_screen_submit").click(function(){


        var arrUpdate = prepareArrayForUpdate();

        $.ajax({
            type: "POST",
            url:"/splitscreen/update/",
            data: {postData: arrUpdate},
            success:function(data){
              console.log(data);
            }
        });
    });

    function prepareArrayForUpdate() {
        var arrUpdate = [];
        for (var i = 1; i < 7; i++ ) {
            arrUpdate.push($("#screen"+i+"_url").val());
        }
        return JSON.stringify(arrUpdate);
    }
});