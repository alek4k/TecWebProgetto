$(document).ready(function () {

    $(document).scroll(function () {
        var y = $(document).scrollTop();
        if (window.innerWidth > 600) {
            if (y >= $("#topHeader").height()) {
                $("#navbar").css({"position": "fixed", "top": "0"});
            } else {
                $("#navbar").css("position", "static");
            }
        }
    });


    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});

