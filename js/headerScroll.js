$(document).ready(function() {

    navHeaderSettings();

    $(document).scroll(function() {
        var y = $(document).scrollTop();
        if (window.innerWidth > 600) {
            if (y >= $("#topHeader").height()) {
                $("#navbar").css({"position": "fixed", "top": "0"});
            } else {
                $("#navbar").css("position", "static");
            }
        }
    });

    $('#hamburger-menu').on("click",function(){
        $('#navbar').toggleClass("visible");
        if ($(this).find($(".fas")).hasClass('fa-times')) {
            $(this).find($(".fas")).removeClass('fa-times').addClass('fa-bar');
            //$('html, body').css({overflow: 'auto'});
        }
        else {
            $(this).find($(".fas")).removeClass('fa-bar').addClass('fa-times');
            //$('html, body').css({overflow: 'hidden'});
        }
    })

});

$(window).on('resize', function() {
    navHeaderSettings();
});

function navHeaderSettings() {
    if (window.innerWidth <= 600) {
        $("#navbar").css({"padding-top": $("#topHeader").height(), "position": "fixed"});
        //$("#navbar").css("position", "fixed");
    }
    else {
        $("#navbar").css({"padding-top": "0", "position": "static"});
        //$("#navbar").css("position", "static");
    }
}
