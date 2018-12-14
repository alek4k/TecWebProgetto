$(document).ready(function() {

    $(document).scroll(function() {
        var y = $(document).scrollTop();
        var header = $("#navbar");
        if(y >= $("#topHeader").height())  {
            header.css({position: "fixed", "top" : "0"});
        } else {
            header.css("position", "static");
        }
    });
});
