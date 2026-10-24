$(function () {
    $(".ressources-slider").slick({
        dots: false,
        arrows: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    $(".location-slider").slick({
        dots: false,
        arrows: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
    });

    const img = document.createElement("img");
    img.src = "/images/Logo.svg";

    $("#menu").mmenu({
        extensions: ["fullscreen"],
        navbar: {
            title: "",
        },
        navbars: {
            content: [img, "close"],
            height: 2,
        },
        offCanvas: {
            position: "right",
        },
    });

    let api = $("#menu").data("mmenu");
    api.bind("closed", function () {
        api.closeAllPanels();
    });

    // if ( jQuery('.main-speaker').length > 0) {
    //   $('.main-speaker').masonry({
    //     itemSelector: '.speakers',
    //     columnWidth: '.speakers'
    //   });
    // };

    $(function () {
        /* $(".tabs-nav a").click(function () {
            // Check for active
            $(".tabs-nav li").removeClass("active");
            $(this).parent().addClass("active");

            // Display active tab
            let currentTab = $(this).attr("href");
            $(".tabs-content > div").hide();
            $(currentTab).show();

            return false;
        });*/

        $(".achievement-tabs-nav a").click(function () {
            // Check for active
            $(".achievement-tabs-nav li").removeClass("active");
            $(this).parent().addClass("active");

            // Display active tab
            let currentTab = $(this).attr("href");
            $(".achievement-tabs-content > div").hide();
            $(currentTab).show();

            return false;
        });
    });
});

$(".tabs-nav a").click(function () {
    // $('.location-slider').slick('refresh');
});

const counters = document.querySelectorAll(".counter");

counters.forEach((counter) => {
    counter.innerText = "0";
    const updateCounter = () => {
        const target = +counter.getAttribute("data-target");
        const count = +counter.innerText;
        const increment = target / 200;
        if (count < target) {
            counter.innerText = `${Math.ceil(count + increment)}`;
            setTimeout(updateCounter, 1);
        } else counter.innerText = target;
    };
    updateCounter();
});

if (jQuery(".blue-section").length > 0) {
    setTimeout(function () {
        var stickyTop = jQuery(".blue-section").offset().top - 0;
        jQuery(window).on("scroll", function () {
            if (jQuery(window).scrollTop() >= stickyTop) {
                jQuery(".blue-section").addClass("show");
                // const counters = document.querySelectorAll(".blue-section .counter");
                // counters.forEach((counter) => {
                //   counter.innerText = "0";
                //   const updateCounter = () => {
                //     const target = +counter.getAttribute("data-target");
                //     const count = +counter.innerText;
                //     const increment = target / 200;
                //     if (count < target) {
                //       counter.innerText = `${Math.ceil(count + increment)}`;
                //       setTimeout(updateCounter, 1);
                //     } else counter.innerText = target;
                //   };
                //   updateCounter();
                // });
            } else {
                jQuery(".blue-section").removeClass("show");
            }
        });
    }, 500);
}

var $btns = $(".gallery-tabbing a").click(function () {
    if (this.id == "all") {
        $("#gallery > div").fadeIn(450);
    } else {
        var $el = $("." + this.id).fadeIn(450);
        $("#gallery > div").not($el).hide();
    }
    $btns.removeClass("active");
    $(this).addClass("active");
});

/* Jesus Rojas */

function playMasterGuide() {
    const btn = $(".play-btn");
    $(btn).siblings("video").trigger("play");
    $(btn).parents(".video-poster").addClass("vid_play");
}

function initSpinner() {
    document.querySelector(".spinner").style.display = "block";

    setTimeout(() => {
        document.querySelector(".page").style.opacity = "1";
        document.querySelector(".spinner").style.display = "none";
    }, 1200);
}
initSpinner();
