    
    <script src="//www.google-analytics.com/analytics.js"></script>
    <script type = "text/javascript">
        var tracker = ga.create('UA-116317084-2', 'kristalgeyikodulleri.com');


        var sidebarVisible = false;
        var currentPageID = "#tm-section-1";

        // Setup Carousel
        function setupCarousel() {
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

        var postData = {};
        var pageCounter = 0;

        $(document).ready(function () {


            function validateEmail(email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }

            function validateStudenId(id) {
                var re = /^[0-9]{8}$/;
                var reyl = /^N[0-9]{8}$/;

                if(re.test(id) || reyl.test(id)){
                    return (re.test(id) || reyl.test(id));
                }
                
            }

            $('#tmMainNav > ul > li:nth-child(1)').on('click', function(){
                if(window.location.pathname.indexOf('survey') !== -1){
                    window.location = "./index.php";
                }
            })
            

            $('form.g-recap').hide();
            //setup all carousel when collapse clicked
            $("[data-toggle=collapse]").on('click', function () {
                setupCarousel();
            });

            function checkPostIsFull(postData) {
                var postLenght = Object.keys(postData).length;
                if (postLenght < 25) {
                    $(".survey-section > div > div.container > span").remove();
                    $(".survey-section > div > div.container").append("<span>Lütfen Bütün Kategorilerden Seçim Yapınız! Tamamlanma : " + postLenght + " / 25</span>");
                } else {
                    $('form.g-recap').show();
                    $(".survey-section > div > div.container > span").remove();

                }
            }

            $(".quiz_block_body_list_item_content").find("label").on('click', function (e) {
                e.preventDefault();

                var dataAttr = $(this).attr("for");
                var inputData = $('input[value=' + dataAttr + ']');
                var key = $(inputData).attr('name');
                var label = $(this).find($('input')).attr('name');
                var getSameSubCategory = $('body').find($('input[name=' + label + ']').parent().parent());

                for (var elem = 0; elem < getSameSubCategory.length; elem++) {
                    $(getSameSubCategory[elem]).removeClass("quiz_block_body_list_item_content_block_checked");
                }

                $(this).find(".quiz_block_body_list_item_content_block").addClass("quiz_block_body_list_item_content_block_checked");
                postData[key] = $(this).find('span').text().trim();
                checkPostIsFull(postData);


            });

            $(".page").hide();
            $("#page-0").show();





            function initializeSubmitButton(pageCounter) {
                if (pageCounter === 3) {
                    checkPostIsFull(postData);
                    $(".next-button").text('GÖNDER');
                } else {
                    $(".next-button").text('İLERİ');
                }
            }
            initializeSubmitButton(pageCounter);

            $(".next-button").on("click", function () {
                if(pageCounter === 0){
                    var dataName = $('input[name="name"]').val();
                    var dataId = $('input[name="student-id"]').val();
                    var dataMail = $('input[name="mail"]').val();
                    if(dataName.length === 0){
                        alert('Lütfen Geçerli Ad Soyad Giriniz');
                        return;
                    }
                    if(!validateStudenId(dataId)){
                        alert('Lütfen Geçerli Bir Öğrenci Numarası Giriniz');
                        return;
                    }
                    if(!validateEmail(dataMail)){
                        alert('Lütfen Geçerli Bir E-posta Adresi Giriniz');
                        return;
                    }
                    
                    
                    
                }
                if (pageCounter !== 3) {
                    $(window).scrollTop(0);
                    pageCounter++;
                    pageSwicher(pageCounter);
                } else {
                    if(localStorage.getItem("savedUser")){
                        alert('Birden fazla oy Kullanamazsınız!');
                    }else{
                        if (pageCounter === 3 && Object.keys(postData).length >= 25) {
                            var recapToken = $('.g-recap').serialize();

                            var dataName = $('input[name="name"]').val();
                            var dataId = $('input[name="student-id"]').val();
                            var dataMail = $('input[name="mail"]').val();

                            if (recapToken.length > "g-recaptcha-response=".length) {
                                $.ajax({
                                    type: "POST",
                                    url: "./send_data.php",
                                    data: {
                                        name: dataName,
                                        studentId: dataId,
                                        mail: dataMail,
                                        result: JSON.stringify(postData) + ",\n"
                                    },
                                    success: function (data) {
                                        alert('Gönderiminiz Kaydedildi. Teşekkürler.');
                                        tracker.send('event', 'Submit', 'Submit', 'Submit-Data');
                                        window.location = "index.php";
                                    }
                                });
                                localStorage.setItem("savedUser", "true");
                            }
                        } else {
                            alert('Lütfen Eksiksiz Seçim Yapınız!');
                        }
                    }
                    
                }
                initializeSubmitButton(pageCounter);
            });

            $(".pre-button").on("click", function () {
                $(window).scrollTop(0);
                if (pageCounter !== 0) {
                    pageCounter--;
                    pageSwicher(pageCounter);
                }
                initializeSubmitButton(pageCounter);
            });

            function pageSwicher(pageCounter) {
                $(".page").hide();
                $("#page-" + pageCounter).show();
            }

            $('#tm-section-1>div>header>h1').on('click', function(){
                $('#tmMainNav > ul > li:nth-child(6) > a').click();
            });


            $('#tmMainNav > ul > li:nth-child(6) > a').on('click', function(){
                tracker.send('event', 'Sidebar', 'Click', 'Survey');
                if(window.location.pathname.indexOf('survey') === -1){
                    window.location = "./survey.php";
                }
            })
            $(".footer-link").on('click', function(e){
                e.preventDefault();
                tracker.send('event', 'Footer', 'Click', 'Berkan-Sezer');
                window.open("https://linkedin.com/in/k-berkan-sezer-316763148/", '_blank')
            });
            $("#tmMainNav li").on('click', function(){
                tracker.send('event', 'Sidebar', 'Click', $(this).find('span').text().lenght ? $(this).find('span').text() : "logo");
            });
        }); 
    </script>