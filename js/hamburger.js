$(document).ready(function () {

    $('#hamburger-menu').on("click", function () {
        $('#navbar').toggleClass("visible");
        if ($(this).find($(".fas")).hasClass('fa-times')) {
            $(this).find($(".fas")).removeClass('fa-times').addClass('fa-bar');
            //$('html, body').css({overflow: 'auto'});
        } else {
            $(this).find($(".fas")).removeClass('fa-bar').addClass('fa-times');
            //$('html, body').css({overflow: 'hidden'});
        }
    })

});
