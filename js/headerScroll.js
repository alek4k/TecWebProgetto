$(document).ready(function() {

    navHeaderSettings();

    $(document).scroll(function() {
        var y = $(document).scrollTop();
        var header = $("#navbar");
        if ($(window).width() > 600) {
            if (y >= $("#topHeader").height()) {
                header.css({position: "fixed", "top": "0"});
            } else {
                header.css("position", "static");
            }
        }
        else {
            header.css({position: "fixed", "top": "0"});
        }
    });

    $('#hamburger-menu').on("click",function(){
        console.log("dai");
        $('#navbar').toggleClass("visible");
    })

});

$(window).on('resize', function() {
    navHeaderSettings();
});

function navHeaderSettings() {
    if ($(window).width() <= 600) {
        $("#navbar").css("padding-top", $("#topHeader").height());
        $("#navbar").css("position", "fixed");
    }
    else {
        $("#navbar").css("padding-top", "0");
        $("#navbar").css("position", "static");
    }
}
