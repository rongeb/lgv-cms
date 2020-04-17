

$(function () {
    "use strict";

    var $window = $(window);
    var $document = $(document);
    var winWidthSm = 991;
    var $body = $('body');

    $(window).load(function () {

        // SITE PRELOADER                     ||----------- 

        $('#loader').fadeOut();
        $('#preloader').delay(350).fadeOut('slow');
        $('body').delay(350).css({ 'overflow': 'visible' });

        // Portfolio Grid Masonry
        containerGridMasonry();
    })


    // ---------------------------------------------------------------------------------------------------------------------------->
    // GENERAL SCRIPTS FOR ALL PAGES    ||----------- 
    // ---------------------------------------------------------------------------------------------------------------------------->

    $(document).ready(function () {
        fullScreenSlider();
        int_introHeight();
        scroll();
        pluginElement();
        sliderHero();
        sliderAll();
        containerGridMasonry();
        scrollCallbackEle();
        shortcodeElements();

    });


    $(window).resize(function () {
        int_introHeight();
    })


    $(window).scroll(function () {

    });





    // ---------------------------------------------------------------------------------------------------------------------------->
    // SCROLL FUNCTIONS   ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->

    function scroll() {

        // //Click Event to Scroll to Top
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.scroll-top').fadeIn();
            } else {
                $('.scroll-top').fadeOut();
            }


        });
        $('.scroll-top').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 800);
            return false;
        });

        // Scroll Down Elements
        $('.scroll-down[href^="#"], .scroll-to-target[href^="#"]').on('click', function (e) {
            e.preventDefault();

            var target = this.hash;
            var $target = $(target);

            $('html, body').stop().animate({
                'scrollTop': $target.offset().top
            }, 900, 'swing', function () {
                window.location.hash = target;
            });
        });

    };


    // ---------------------------------------------------------------------------------------------------------------------------->
    // NAVIGATION MENU FUNCTIONS   ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->
    navigation_menu();
    function navigation_menu() {

        var navMenuLink = $(".nav-menu > ul > li"),
          //  menuIconBtn = $('.menu-dropdown-icon'),
            dropDown_Menu = $('.nav-dropdown'),
            nav_menu_item = $('.nav-menu-item'),
            nav_Mobile_Btn = $(".menu-mobile-btn"),
            nav_menu_wrap = $(".nav-menu");

        // Dropdown Menu Icon
        $('.nav-menu > ul > li:has( > .nav-dropdown)').prepend('<span class="menu-dropdown-icon"></span>');
        $('.nav-dropdown > ul > li:has( > .nav-dropdown-sub)').addClass('sub-dropdown-icon');
        $(".nav-menu > ul > li:has( > .nav-dropdown)").addClass('dd-menu-dropdown-icon');
        $window.on('resize', function () {
            if ($(window).width() > winWidthSm) {
                $('.nav-dropdown > ul > li ul li:has(.nav-dropdown-sub)').addClass('sub-dropdown-icon');
            };
            if ($(window).width() <= winWidthSm) {
                $('.nav-dropdown > ul > li ul li:has(.nav-dropdown-sub)').removeClass('sub-dropdown-icon');
            };
        });

        // Dropdown Menu
        navMenuLink.on('mouseenter mouseleave', function (e) {
            if ($(window).width() > winWidthSm) {
                $(this).children(".nav-dropdown").stop(true, false).fadeToggle(150);
                e.preventDefault();
            }
        });
        $('.menu-dropdown-icon').on('click', function () {
            if ($(window).width() <= winWidthSm) {
                $(this).siblings(".nav-dropdown").stop(true, false).fadeToggle(150);
            }
        });
        $window.on('resize', function () {
            if ($(window).width() > winWidthSm) {
                $(".nav-dropdown, .nav-dropdown-sub").fadeOut(150);
            }
        });

        // Sub Dropdown Menu
        nav_menu_item.on('mouseenter mouseleave', function (e) {
            if ($(window).width() > winWidthSm) {
                $(this).children(".nav-dropdown-sub").stop(true, false).fadeToggle(150);
                e.preventDefault();
            }
        });
        nav_menu_item.on('click', function () {
            if ($(window).width() <= winWidthSm) {
                $(this).children(".nav-dropdown-sub").stop(true, false).fadeToggle(150);
            }
        });

        // Dropdon Center align
        $window.on('resize', function () {
            dropDown_Menu.each(function (indx) {
                if ($(this).hasClass("center")) {
                    var dropdownWidth = $(this).outerWidth();
                    var navItemWidth = $(this).parents(nav_menu_item).outerWidth();
                    var dropdown_halfWidth = parseInt(dropdownWidth / 2);
                    var navItem_halfWidth = parseInt(navItemWidth / 2);
                    var totlePosition = parseInt(dropdown_halfWidth - navItem_halfWidth);
                    if ($window.width() > winWidthSm) {
                        $(this).css("left", "-" + totlePosition + "px");
                    } else {
                        $(this).css("left", "0");
                    };
                }
            });
        });

        // Mobile Menu Button
        nav_Mobile_Btn.on('click', function (e) {
            nav_menu_wrap.toggleClass('show-on-mobile');
            $(this).toggleClass("active");
            e.preventDefault();
        });

    };


    // ---------------------------------------------------------------------------------------------------------------------------->
    // HEADER & STICKY HEADER FUNCTIONS   ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->
    stickHeader();
    function stickHeader() {

        var headerNavOffset = $('.header-nav').offset().top;
        var stickyOffset = parseInt(headerNavOffset + 400);
        $(window).on('scroll', function () {
            var sticky = $('.header--sticky'),
                scroll = $(window).scrollTop();

            if (scroll >= stickyOffset) sticky.addClass('fixed');
            else sticky.removeClass('fixed');
        });

        // "Sticky" Desktop Device Enable ---- Small Device Disable
        $(function () {
            var $stickyEle = $('.header--sticky');
            $window.on('resize', function resize() {
                if ($window.width() > winWidthSm) {
                    return $stickyEle.removeClass('no-stick');
                }
                $stickyEle.addClass('no-stick');

            }).trigger('resize');
        });

        $window.on('resize', function () {
            // Header height
            var headerHeight = function () {
                $('.header').each(function () {
                    if ($(window).width() > winWidthSm) {
                        var element = $(this);
                        element.css('min-height', element.outerHeight());
                    };
                    if ($(window).width() <= winWidthSm) {
                        var element = $(this);
                        element.css('min-height', '1px');
                    };
                });
            };
            headerHeight();

            // Offset Topbar
            var offsetTopbar = function () {
                $('.site-wraper').each(function () {
                    var offset = $('.offset-topbar'),
                        element = $('.page-contaiter');
                    element.css('padding-top', offset.outerHeight());
                });
            };
            offsetTopbar();
        });
    };


    //---------------------------------------------------------------------------------------------------------------------------->
    //      Sidebar Menu
    //---------------------------------------------------------------------------------------------------------------------------->
    sidebarMenu();
    function sidebarMenu() {

        var sidebarMenuBtn = $('.sidebar-menu_btn'),
            sidebarMenu = $('.sidebar-menu'),
            sidebarMenuClose = $('.sidebar-close-icon'),
            sidebarBtnActive = 'active',
            sidebarMenuActive = 'sidebar-menu-open',
            sidebarBtnParentActive = 'cart-active';

        var openSidebar = function () {
            sidebarMenuBtn.toggleClass(sidebarBtnActive);
            sidebarMenu.toggleClass(sidebarMenuActive);
            sidebarMenuBtn.parent().toggleClass(sidebarBtnParentActive);
        }
        var closeSidebar = function () {
            sidebarMenuBtn.removeClass(sidebarBtnActive);
            sidebarMenu.removeClass(sidebarMenuActive);
            sidebarMenuBtn.parent().removeClass(sidebarBtnParentActive);
        }

        sidebarMenuClose.on('click', function (event) {
            closeSidebar();
        });

        $('.search-menu_btn, .cart-menu_btn').on('click', function (e) {
            closeSidebar();
        });

        sidebarMenuBtn.on('click', function (event) {
            event.stopPropagation();
            openSidebar();
        });

        $document.on('click touchstart', function (event) {
            if (!$(event.target).closest('.sidebar-menu, .sidebar-menu_btn').length) {
                closeSidebar();
            }
        });

    };

    //---------------------------------------------------------------------------------------------------------------------------->
    //      SearchBar Menu   
    //---------------------------------------------------------------------------------------------------------------------------->
    searchMenuBar();
    function searchMenuBar() {

        var searchMenuBtn = $('.search-menu_btn'),
            searchMenu = $('.search-menu-bar'),
            searchMenuClose = $('.search-close-icon'),
            searchBtnActive = 'active',
            searchMenuActive = 'search-menu-open',
            searchBtnParentActive = 'search-active';

        var closeSearchbar = function () {
            searchMenu.removeClass(searchMenuActive);
            searchMenu.siblings(searchMenuBtn).removeClass(searchBtnActive);
            searchMenu.parent().removeClass(searchBtnParentActive);
        }

        searchMenuBtn.on('click', function (e) {
            e.stopPropagation();
            if ($(this).hasClass(searchBtnActive)) {
                $(this).removeClass(searchBtnActive);
                $(this).siblings(searchMenu).removeClass(searchMenuActive);
                $(this).parent().removeClass(searchBtnParentActive);
            } else {
                searchMenuBtn.removeClass(searchBtnActive).siblings(searchMenu).removeClass(searchMenuActive).parent().removeClass(searchBtnParentActive);
                $(this).addClass(searchBtnActive);
                $(this).siblings(searchMenu).addClass(searchMenuActive);
                $(this).parent().addClass(searchBtnParentActive);
                $('input.seach-input').focus();
            }
        });

        searchMenuClose.on('click', function (e) {
            closeSearchbar();
        });

        $('.cart-menu_btn, .sidebar-menu_btn').on('click', function (e) {
            closeSearchbar();
        });

        $document.on('click touchstart', function (e) {
            if (!$(e.target).closest(searchMenu, searchMenuBtn).length) {
                searchMenuBtn.removeClass(searchBtnActive);
                searchMenu.removeClass(searchMenuActive);
                searchMenuBtn.parent().removeClass(searchBtnParentActive);
                e.stopPropagation();
            }
        });
    };

    //---------------------------------------------------------------------------------------------------------------------------->
    //      Cart Menu   
    //---------------------------------------------------------------------------------------------------------------------------->
    cartMenuBar();
    function cartMenuBar() {

        var cartMenuBtn = $('.cart-menu_btn'),
            cartMenu = $('.cart-menu-bar'),
            cartMenuClose = $('.cart-close-icon'),
            cartBtnActive = 'active',
            cartMenuActive = 'cart-menu-open',
            cartBtnParentActive = 'cart-active';

        var closeCartbar = function () {
            cartMenu.removeClass(cartMenuActive);
            cartMenu.siblings(cartMenuBtn).removeClass(cartBtnActive);
            cartMenu.parent().removeClass(cartBtnParentActive);
        }

        cartMenuBtn.on('click', function (e) {
            e.stopPropagation();
            if ($(this).hasClass(cartBtnActive)) {
                $(this).removeClass(cartBtnActive);
                $(this).siblings(cartMenu).removeClass(cartMenuActive);
                $(this).parent().removeClass(cartBtnParentActive);
            } else {
                cartMenuBtn.removeClass(cartBtnActive).siblings(cartMenu).removeClass(cartMenuActive).parent().removeClass(cartBtnParentActive);
                $(this).addClass(cartBtnActive);
                $(this).siblings(cartMenu).addClass(cartMenuActive);
                $(this).parent().addClass(cartBtnParentActive);
            }
        });

        cartMenuClose.on('click', function (e) {
            closeCartbar();
        });

        $('.search-menu_btn, .sidebar-menu_btn').on('click', function (e) {
            closeCartbar();
        });

        $document.on('click touchstart', function (e) {
            if (!$(e.target).closest(cartMenu, cartMenuBtn).length) {
                cartMenuBtn.removeClass(cartBtnActive);
                cartMenu.removeClass(cartMenuActive);
                cartMenuBtn.parent().removeClass(cartBtnParentActive);
                e.stopPropagation();
            }
        });
    };


    // ----------------------------------------------------------------
    // Intro Height
    // ----------------------------------------------------------------
    function int_introHeight() {
        var windiwHeight = $(window).height();
        // Intro Height
        $('.js-fullscreen-height').css('height', windiwHeight);
    };

    // ----------------------------------------------------------------
    // Backgrounds Image (Slider, Section, etc..)
    // ----------------------------------------------------------------
    var pageSection = $('.slide-bg-image, .bg-image');
    pageSection.each(function (indx) {

        if ($(this).attr("data-background-img")) {
            $(this).css("background-image", "url(" + $(this).data("background-img") + ")");
        }
    });

    // ---------------------------------------------------------------------------------------------------------------------------->
    // FULLSCREEN SLIDER FUNCTIONS  ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->
    function fullScreenSlider() {
        if ($('.fullscreen-carousel').length > 0) {

            $('.fullscreen-carousel').flexslider({
                animation: "slide",
                //  startAt: 0,
                animationSpeed: 700,
                animationLoop: true,
                slideshow: true,
                easing: "swing",
                controlNav: false,
                before: function (slider) {
                    //Slide Caption Animate
                    $('.fullscreen-carousel .intro-content-inner').fadeOut().animate({ top: '80px' }, { queue: false, easing: 'easeOutQuad', duration: 700 });
                    slider.slides.eq(slider.currentSlide).delay(400);
                    slider.slides.eq(slider.animatingTo).delay(400);

                },
                after: function (slider) {
                    //Slide Caption Animate
                    $('.fullscreen-carousel .flex-active-slide').find('.intro-content-inner').fadeIn(2000).animate({ top: '0' }, { queue: false, easing: 'easeOutQuad', duration: 1200 });

                    // Header Dark Light
                    headerDarkLight_with_flexslider();

                },
                start: function (slider) {
                    $('body').removeClass('loading');

                    // Header Dark Light
                    headerDarkLight_with_flexslider();

                },
                useCSS: true,
            });
        };

        // Header Dark Light
        function headerDarkLight_with_flexslider() {

            var color = $('.fullscreen-carousel').find('li.flex-active-slide').attr('data-slide');
            if (color == 'dark-slide') {
                $('#header').addClass('header').removeClass('header--dark');
                $('#header').removeClass('header-default');
            }
            if (color == 'light-slide') {
                $('#header').addClass('header--dark').removeClass('header--light');
                $('#header').removeClass('header-default');
            }
            if (color == 'default-slide') {
                $('#header').removeClass('header--light');
                $('#header').removeClass('header--dark');
                $('#header').addClass('header');
            }
        };

        // "fullscreen-carousel" height
        fullScreenCarousel();
        function fullScreenCarousel() {
            var windowWidth = $(window).width();
            var windowHeight = $(window).height();

            if ($(window).width() > 767) {
                $('.hero-slider-1 .slides .js-Slide-fullscreen-height').css("height", windowHeight);
            }
            else {
                $('.hero-slider-1 .slides .js-Slide-fullscreen-height').css("height", '400px');
            }

        };
        $(window).resize(function () {
            fullScreenCarousel();
        });


    };

    // ---------------------------------------------------------------------------------------------------------------------------->
    // SLIDER FUNCTIONS   ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->

    function sliderAll() {

        // fullwidth Slider
        $('.fullwidth-slider').owlCarousel({
            slideSpeed: 400,
            singleItem: true,
            autoHeight: true,
            navigation: true,  // Show next and prev buttons
            pagination: true,  // Show pagination buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],

        });

        // Image Slider
        $('.image-slider').owlCarousel({
            navigation: true,  // Show next and prev buttons
            pagination: true,  // Show pagination buttons
            slideSpeed: 350,
            paginationSpeed: 400,
            singleItem: true,
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            autoPlay: false,
            autoHeight: true,
            responsive: true
        });

        // Testimonial Slider
        $('.testimonial-carousel').owlCarousel({
            autoPlay: true,
            autoHeight: true,
            stopOnHover: true,
            singleItem: true,
            slideSpeed: 350,
            pagination: true,  // Show pagination buttons
            navigation: false,  // Hide next and prev buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            //  responsive: true
        });

        // Team Carousel
        $('.team-carousel').owlCarousel({
            autoPlay: false,
            stopOnHover: true,
            items: 3,
            itemsDesktop: [1170, 3],
            itemsDesktopSmall: [1024, 2],
            itemsTabletSmall: [768, 1],
            itemsMobile: [480, 1],
            pagination: false,  // Hide pagination buttons
            navigation: false,  // Hide next and prev buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
        });

        // Client Carousel
        $('.client-carousel').owlCarousel({
            autoPlay: 2500,
            stopOnHover: true,
            items: 5,
            itemsDesktop: [1170, 4],
            itemsDesktopSmall: [1024, 3],
            itemsTabletSmall: [768, 2],
            itemsMobile: [480, 1],
            pagination: false,  // hide pagination buttons
            navigation: false,  // hide next and prev buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
        });

        // Content Slider
        $('.content-carousel').owlCarousel({
            autoPlay: true,
            autoHeight: true,
            stopOnHover: true,
            singleItem: true,
            slideSpeed: 500,
            pagination: false,  // Hide pagination buttons
            navigation: true,   // Show next and prev buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: true
        });

        // Item-5 Carousel
        $('.item5-carousel').owlCarousel({
            autoPlay: 2500,
            stopOnHover: true,
            items: 5,
            itemsDesktop: [1170, 3],
            itemsDesktopSmall: [1024, 2],
            itemsTabletSmall: [768, 1],
            itemsMobile: [480, 1],
            pagination: true,  // Show pagination buttons
            navigation: true,  // Show next and prev buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
        });

        // Item-4 Carousel
        $('.item4-carousel').owlCarousel({
            autoPlay: 2500,
            stopOnHover: true,
            items: 4,
            itemsDesktop: [1170, 3],
            itemsDesktopSmall: [1024, 2],
            itemsTabletSmall: [768, 1],
            itemsMobile: [480, 1],
            pagination: false,  // Hide pagination buttons
            navigation: true,  // Show next and prev buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
        });

        // Item-3 Carousel
        $('.item3-carousel').owlCarousel({
            autoPlay: false,
            stopOnHover: true,
            items: 3,
            itemsDesktop: [1170, 3],
            itemsDesktopSmall: [1024, 2],
            itemsTabletSmall: [768, 1],
            itemsMobile: [480, 1],
            pagination: true,  // show pagination buttons
            navigation: true,  // Show next and prev buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
        });

        // Item-1 Carousel
        $('.item1-carousel').owlCarousel({
            autoPlay: false,
            autoHeight: true,
            stopOnHover: true,
            singleItem: true,
            slideSpeed: 350,
            pagination: true,  // Show pagination buttons
            navigation: true,  // Show next and prev buttons
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: true
        });

    };



    // ---------------------------------------------------------------------------------------------------------------------------->
    // SLIDER-HERO FUNCTIONS   ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->

    function sliderHero() {

        $('.slider-hero').owlCarousel({
            navigation: true, // Show next and prev buttons
            slideSpeed: 700,
            paginationSpeed: 400,
            pagination: true,
            addClassActive: true,

            touchDrag: true,
            singleItem: true,
            navigationText: false,
            autoPlay: false,
            autoHeight: false,

            //responsive: true,
            //itemsDesktop: [3000, 1],
            //itemsDesktopSmall: [1440, 1],
            //itemsTablet: [1024, 1],
            //itemsTabletSmall: [600, 1],
            //itemsMobile: [360, 1],

            beforeMove: beforeMove,
            afterMove: afterMove,
            afterInit: afterInit

        });
        function beforeMove() {
            $('.slider-hero .overlay-hero .caption-hero').fadeOut(1);

        }
        function afterMove() {
            $('.slider-hero .owl-item.active ').find('.caption-hero').delay(500).fadeIn(1500);
            BackgroundCheck.refresh();

        }
        function afterInit() {
            $('.slider-hero .owl-item.active ').find('.caption-hero').delay(500).fadeIn(1500);
            BackgroundCheck.init({
                targets: '.full-intro',
                images: '.owl-carousel .item img',

            });

        }

        $(window).height(function () {
            heroResize();
            function heroResize() {
                var windowHeight = $(window).innerHeight();
                $('.slider-hero, .full-screen-intro').css('height', windowHeight);
            };
            $(window).resize(function () {
                heroResize();
            });
        });

    };





    // ---------------------------------------------------------------------------------------------------------------------------->
    // PLUGIN MEDIA FUNCTIONS  ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->

    function pluginElement() {

        // Media Player Elements
        videoElement();
        function videoElement() {
            $('.video').mediaelementplayer({
                loop: true,
                enableKeyboard: false,
                iPadUseNativeControls: false,
                pauseOtherPlayers: false,
                iPhoneUseNativeControls: false,
                AndroidUseNativeControls: false,
                enableAutosize: true
            });
            $('.bg-video').mediaelementplayer({
                loop: true,
                enableKeyboard: false,
                iPadUseNativeControls: false,
                pauseOtherPlayers: false,
                iPhoneUseNativeControls: false,
                AndroidUseNativeControls: false,
                enableAutosize: true,
                alwaysShowControls: false,
            });

            $('.audio').mediaelementplayer({
                audioWidth: '100%',
                pauseOtherPlayers: false,
            });
        };

        // Responsive Media Elements
        $(".video, .audio, .post-media, .post-media iframe").fitVids();



    };


    // ---------------------------------------------------------------------------------------------------------------------------->
    // CONTAINER GRID & MESONRY FUNCTIONS (Portfolio, blog, etc)   ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->

    function containerGridMasonry() {

        // Gria Element

        // ISOTOPE MASONRY ELEMENT  ||--------------
        var $container = $('.container-masonry');
        $container.imagesLoaded(function () {
            $container.isotope({
                itemSelector: '.nf-item',
                layoutMode: 'masonry',
                masonry: {
                    columnWidth: 0,
                    gutter: 0
                },
            });
        });

        // bind filter button click
        $('.container-filter').on('click', '.categories', function () {
            var filterValue = $(this).attr('data-filter');
            $container.isotope({ filter: filterValue });
        });

        // ISOTOPE GRID ELEMENT  ||--------------
        var $container2 = $('.container-grid');
        $container2.imagesLoaded(function () {
            $container2.isotope({
                itemSelector: '.nf-item',
                layoutMode: 'fitRows'
            });
        });

        // bind filter categories click
        $('.container-filter').on('click', '.categories', function () {
            var filterValue = $(this).attr('data-filter');
            $container2.isotope({ filter: filterValue });
        });

        // change active class on categories
        $('.categories-filter').each(function (i, buttonGroup) {
            var $buttonGroup = $(buttonGroup);
            $buttonGroup.on('click', '.categories', function () {
                $buttonGroup.find('.active').removeClass('active');
                $(this).addClass('active');
            });

        });


        // Masonry Element
        var container = $('.masonry');
        container.masonry({
            // columnWidth: 0,
            itemSelector: '.nf-item'
        });

    };

    // ---------------------------------------------------------------------------------------------------------------------------->
    // SCROLL CALLBACK FUNCTION  ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->
    function scrollCallbackEle() {
        //scroll Callback Element
        $('.load-ele-fade').viewportChecker({
            classToAdd: 'visible animated fadeIn',
            offset: 100,
            callbackFunction: function (elem, action) {
            }
        });

        $(function () {

            //scroll Animate Element
            var wow = new WOW({
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 0,
                mobile: false,
                live: true
            })
            wow.init();
        });
    };


    // ----------------------------------------------------------------
    // Parallax Function element
    // ----------------------------------------------------------------

    // Parallax Function element
    $('.parallax').each(function () {
        var $el = $(this);
        $(window).scroll(function () {
            parallax($el);
        });
        parallax($el);
    });


    function parallax($el) {
        var diff_s = $(window).scrollTop();
        var parallax_height = $('.parallax').height();
        var yPos_p = (diff_s * 0.5);
        var yPos_m = -(diff_s * 0.5);
        var diff_h = diff_s / parallax_height;

        if ($('.parallax').hasClass('parallax-section1')) {
            $el.css('top', yPos_p);
        }
        if ($('.parallax').hasClass('parallax-section2')) {
            $el.css('top', yPos_m);
        }
        if ($('.parallax').hasClass('parallax-static')) {
            $el.css('top', (diff_s * 1));
        }
        if ($('.parallax').hasClass('parallax-opacity')) {
            $el.css('opacity', (1 - diff_h * 1));
        }

        if ($('.parallax').hasClass('parallax-background1')) {
            $el.css("background-position", 'left' + " " + yPos_p + "px");
        }
        if ($('.parallax').hasClass('parallax-background2')) {
            $el.css("background-position", 'left' + " " + -yPos_p + "px");

        }
    };

    var parallaxPositionProperty;
    if ($(window).width() >= 1024) {
        parallaxPositionProperty = "position";
    } else {
        parallaxPositionProperty = "transform"
    }

    // Parallax Stellar Plugin element
    $(window).stellar({
        responsive: true,
        positionProperty: parallaxPositionProperty,
        horizontalScrolling: false

    });


    // ---------------------------------------------------------------------------------------------------------------------------->
    // SHORTCODE ELEMENTS  ||-----------
    // ---------------------------------------------------------------------------------------------------------------------------->

    shortcodeElements();
    function shortcodeElements() {

        // Portfolio Lightbox Popup Elements
        lightbox();
        function lightbox() {
            $(".cbox-gallary1").colorbox({
                rel: 'gallary',
                maxWidth: "95%",
                maxHeight: "95%"

            });
            $(".cbox-iframe").colorbox({
                iframe: true,
                maxWidth: "95%",
                maxHeight: "95%",
                innerWidth: 640,
                innerHeight: 390
            });
        };

        // Skills Progressbar Elements
        skillsProgressBar();
        function skillsProgressBar() {
            $('.skillbar').each(function () {
                $(this).find('.skillbar-bar').animate({
                    width: $(this).attr('data-percent')
                }, 2000);
            });
        };

        // Tooltip
        $(".tipped").tipper();

        //Counter
        $('.counter').each(function () {
            var $this = $(this),
                countTo = $this.attr('data-count');
            $({ countNum: $this.text() }).animate({
                countNum: countTo
            },
            {
                duration: 8000,
                easing: 'linear',
                step: function () {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function () {
                    $this.text(this.countNum);
                    //alert('finished');
                }
            });
        });

    };


    // Accordion Function Elements
    accordion();
    function accordion() {

        $('.accordion-title').click(function (e) {

            $(this).next().slideToggle('easeOut');
            $(this).toggleClass('active');
            $("accordion-title").toggleClass('active');
            $(".accordion-content").not($(this).next()).slideUp('easeIn');
            $(".accordion-title").not($(this)).removeClass('active');

        });
        $(".accordion-content").addClass("defualt-hidden");

    };

    // Jquery UI Elements
    jqueryUi();
    function jqueryUi() {

        // Tab Function
        $(function () {
            $(".tabs").tabs();
        });

        // Price Filter Slider
        $(function () {
            $("#range-slider").slider({
                range: true,
                min: 0,
                max: 500,
                values: [0, 300],
                slide: function (event, ui) {
                    $(".price-amount-from").text("$" + ui.values[0]);
                    $(".price-amount-to").text("$" + ui.values[1]);

                }
            });
            $(".price-amount-from").text("$" + $("#range-slider").slider("values", 0));
            $(".price-amount-to").text("$" + $("#range-slider").slider("values", 1));
        });
    };


});