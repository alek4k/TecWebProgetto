$(document).ready(function() {

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

});

