$(document).ready(function () {

    setTimeout(function (){
        navHeaderSettings();
    }, 1000);

});

$(window).on('resize', function () {
    navHeaderSettings();
});

function navHeaderSettings() {
    if (window.innerWidth <= 600) {
        $("#navbar").css({"padding-top": $("#topHeader").height(), "position": "fixed"});
        //$("#navbar").css("position", "fixed");
    } else {
        $("#navbar").css({"padding-top": "0", "position": "static"});
        //$("#navbar").css("position", "static");
    }
}
