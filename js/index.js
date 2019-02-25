var sidebarVisible = false;
var currentPageID = "#tm-section-1";

// Setup Carousel
function setupCarousel() {
    console.log('setup carousel');
    // If current page isn't Carousel page, don't do anything.
    if ($('#tm-section-2').css('display') !== "none") {
        var slider = $('.tm-img-slider');
        var windowWidth = $(window).width();

        if (slider.hasClass('slick-initialized')) {
            slider.slick('destroy');
        }

        if (windowWidth < 640) {
            slider.slick({
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        } else if (windowWidth < 992) {
            slider.slick({
                dots: true,
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1
            });
        } else {
            // Slick carousel
            slider.slick({
                dots: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3
            });
        }

        // Init Magnific Popup
        $('.tm-img-slider').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image',
            gallery: {
                enabled: true
            }
            // other options
        });
    }
}

// Setup Nav
function setupNav() {
    // Add Event Listener to each Nav item
    $(".tm-main-nav a").click(function (e) {
        e.preventDefault();

        var currentNavItem = $(this);
        changePage(currentNavItem);

        setupCarousel();
        setupFooter();

        // Hide the nav on mobile
        $("#tmSideBar").removeClass("show");
    });
}

function changePage(currentNavItem) {
    // Update Nav items
    $(".tm-main-nav a").removeClass("active");
    currentNavItem.addClass("active");

    $(currentPageID).hide();

    // Show current page
    currentPageID = currentNavItem.data("page");
    $(currentPageID).fadeIn(1000);

    // Change background image
    var bgImg = currentNavItem.data("bgImg");
    $.backstretch("img/" + bgImg);
}

// Setup Nav Toggle Button
function setupNavToggle() {

    $("#tmMainNavToggle").on("click", function () {
        $(".sidebar").toggleClass("show");
    });
}

// If there is enough room, stick the footer at the bottom of page content.
// If not, place it after the page content
function setupFooter() {

    var padding = 100;
    var footerPadding = 40;
    var mainContent = $("section" + currentPageID);
    var mainContentHeight = mainContent.outerHeight(true);
    var footer = $(".footer-link");
    var footerHeight = footer.outerHeight(true);
    var totalPageHeight = mainContentHeight + footerHeight + footerPadding + padding;
    var windowHeight = $(window).height();

    if (totalPageHeight > windowHeight) {
        $(".tm-content").css("margin-bottom", footerHeight + footerPadding + "px");
        footer.css("bottom", footerHeight + "px");
    } else {
        $(".tm-content").css("margin-bottom", "0");
        footer.css("bottom", "20px");
    }
}


// Everything is loaded including images.
$(window).on("load", function () {

    // Render the page on modern browser only.
    if (renderPage) {
        // Remove loader
        $('body').addClass('loaded');

        // Page transition
        var allPages = $(".tm-section");

        // Handle click of "Continue", which changes to next page
        // The link contains data-nav-link attribute, which holds the nav item ID
        // Nav item ID is then used to access and trigger click on the corresponding nav item
        var linkToAnotherPage = $("a.tm-btn[data-nav-link]");

        if (linkToAnotherPage != null) {

            linkToAnotherPage.on("click", function () {
                var navItemToHighlight = linkToAnotherPage.data("navLink");
                $("a" + navItemToHighlight).click();
            });
        }

        // Hide all pages
        allPages.hide();

        $("#tm-section-1").fadeIn();

        // Set up background first page
        var bgImg = $("#tmNavLink1").data("bgImg");

        $.backstretch("img/" + bgImg, {
            fade: 500
        });

        // Setup Carousel, Nav, and Nav Toggle
        setupCarousel();
        setupNav();
        setupNavToggle();
        setupFooter();

        // Resize Carousel upon window resize
        $(window).resize(function () {
            setupCarousel();
            setupFooter();
        });
    }
});

$(document).ready(function () {
    var postData = {};
    //setup all carousel when collapse clicked
    $("[data-toggle=collapse]").on('click', function () {
        setupCarousel();
    });
    // center items
    // $('body').find("a.scrolly").on('click', function () {
    //     var url =  this.href.split('#')[1];
    //     if(url === 'contact'){
    //         $('.tm-content').addClass('center-top');
    //     }else{
    //         $('.tm-content').removeClass('center-top');
    //     }
    // });



    $(".quiz_block_body_list_item_content").find("label").on('click', function (e) {
        e.preventDefault();

        var dataAttr = $(this).attr("for");
        var inputData = $('input[value=' + dataAttr + ']');
        var key = $(inputData).attr('name');
        postData[key] = $(this).find('span').text().trim();
        console.log(postData);
        // for get count of object
        // Object.keys(postData).length); 



        $(".quiz_block_body_list_item_content_block").removeClass("quiz_block_body_list_item_content_block_checked");
        $(this).find(".quiz_block_body_list_item_content_block").addClass("quiz_block_body_list_item_content_block_checked")
    })


});


$(".page").hide();
$("#page-1").show();
var pageCounter = 1;

$(".next-button").on("click", function () {
    if (pageCounter !== 3) {
        pageCounter++;
        pageSwicher(pageCounter);
    }
});

$(".pre-button").on("click", function () {
    if (pageCounter !== 1) {
        pageCounter--;
        pageSwicher(pageCounter);
    }
});

function pageSwicher(pageCounter) {
    $(".page").hide();
    $("#page-" + pageCounter).show();
}


// $(document).ready(function() {
//     carousel({
//         slider: '.quiz_block_body_list .quiz_block_body_list_item',
//         pixelOffset: 780,
//         shift: 780,
//         btnLeft: '.quiz_block_body_btn_grup_back',
//         btnRight: '.quiz_block_body_btn_grup_next',
//         time: 250,
//         progress: {
//             lineProgress: '.quiz_block_headed_progressbar_line',
//             percentProgress: '.quiz_block_headed_percent_int',
//             currentProgress: 0,
//             intProgress: 16,
//         },
//     });
// });
//
//
// var carousel = function(obj) {
//     let sliderLength = $(obj.slider).length;
//     let maxOffset = 0;
//     let minOffset = -(sliderLength - 1) * obj.pixelOffset;
//     let currentLeft = 0;
//
//     let currentProgress = obj.progress.currentProgress;
//     let percentProgress = $(obj.progress.percentProgress);
//     let lineProgress = $(obj.progress.lineProgress);
//     let intProgress = obj.progress.intProgress;
//
//     $(obj.btnRight).on("click", function() {
//         if(currentLeft !== minOffset) {
//             currentLeft -= obj.shift;
//             $(obj.slider).animate({
//                 left: currentLeft+"px",
//             }, obj.time);
//             if(obj.progress !== 0) {
//                 currentProgress += intProgress;
//                 percentProgress.text(currentProgress+"%");
//                 lineProgress.css({
//                     width: currentProgress+"%",
//                 });
//             }
//         }
//     });
//
//     $(obj.btnLeft).on("click", function() {
//         if(currentLeft !== maxOffset) {
//             currentLeft += obj.shift;
//             $(obj.slider).animate({
//                 left: currentLeft+"px",
//             }, obj.time);
//             if(obj.progress !== 0) {
//                 currentProgress -= intProgress;
//                 percentProgress.text(currentProgress+"%");
//                 lineProgress.css({
//                     width: currentProgress+"%",
//                 });
//             }
//         }
//     });
// }