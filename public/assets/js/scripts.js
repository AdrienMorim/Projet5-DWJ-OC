/*
Theme Name: CV Adrien Morim
Author: Adrien Morim
Author URL: morimadrien.fr
*/

/*
    1. Preloader
    2. Animated scrolling / Scroll Up
    3. Full Screen Slider
    4. Sticky Menu
    5. Back To Top
    6. Countup
    7. Progress Bar
    8. More skill
    9. Shuffle
    10. Magnific Popup
    11. Google Map
    12. Navbar Dashbord
*/

// Quand le document HTML est prêt lance jQuery
jQuery(function($) {

    'use strict';

    /* ---------------------------------------------- /*
     * Preloader
    /* ---------------------------------------------- */

    $(document).ready(function() {
        $('#pre-status').delay(250).fadeOut();
        $('#tt-preloader').delay(150).fadeOut('slow');
    });

    // -------------------------------------------------------------
    // Animated scrolling / Scroll Up
    // -------------------------------------------------------------

    (function () {
        $("[href='#']").bind("click", function(e){
            let anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top
            }, 1000);
            e.preventDefault();
        });
    }());

    // -------------------------------------------------------------
    // Full Screen Slider
    // -------------------------------------------------------------
    (function () {
        $(".tt-fullHeight").height($(window).height());
        $(".tt-backend").height($(window).height());

        $(window).resize(function(){
            $(".tt-fullHeight").height($(window).height());
            $(".tt-backend").height($(window).height());
        });
    }());

    // -------------------------------------------------------------
    // Sticky Menu
    // -------------------------------------------------------------

    (function () {
        $('#nav').sticky({
            topSpacing: 0
        });

        $('body').scrollspy({
            target: '.navbar-custom',
            offset: 70
        })
    }());

    // -------------------------------------------------------------
    // Back To Top
    // -------------------------------------------------------------

    (function () {
        $(document).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.scroll-up').fadeIn();
            } else {
                $('.scroll-up').fadeOut();
            }
        });
    }());

    // -------------------------------------------------------------
    // Countup
    // -------------------------------------------------------------
    $('.count-wrap').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $(this).find('.timer').each(function () {
                let $this = $(this);
                $({ Counter: 0 }).animate({ Counter: $this.text() }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });
            $(this).unbind('inview');
        }
    });

    // -------------------------------------------------------------
    // Progress Bar
    // -------------------------------------------------------------
 
    $('.skill-progress').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $.each($('div.progress-bar'),function(){
                $(this).css('width', $(this).attr('aria-valuenow')+'%');
            });
            $(this).unbind('inview');
        }
    });
    
    // -------------------------------------------------------------
    // More skill
    // -------------------------------------------------------------
    $('.more-skill').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $('.chart').easyPieChart({
                //ma configuration
                easing: 'easeOut',
                delay: 3000,
                barColor: function(percent){
                    let ctx = this.renderer.getCtx();
                    let canvas = this.renderer.getCanvas();
                    let gradient = ctx.createLinearGradient(0,0,canvas.width,0);
                        gradient.addColorStop(1, "#00B0F4");
                        gradient.addColorStop(0, "#67CCCC");
                    return gradient;
                },
                trackColor:'rgba(255,255,255,0.2)',
                scaleColor: false,
                lineWidth: 8,
                size: 140,
                animate: 2000,
                onStep: function(from, to, percent) {
                    this.el.children[0].innerHTML = Math.round(percent);
                }

            });
            $(this).unbind('inview');
        }
    });

    // -------------------------------------------------------------
    // Shuffle
    // -------------------------------------------------------------

    (function () {

        let $grid = $('#grid');

        $grid.shuffle({
            itemSelector: '.portfolio-item'
        });

        /* reshuffle when user clicks a filter item */
        $('#filter a').click(function (e) {
            e.preventDefault();

            // set active class
            $('#filter a').removeClass('active');
            $(this).addClass('active');

            // get group name from clicked item
            let groupName = $(this).attr('data-group');

            // reshuffle grid
            $grid.shuffle('shuffle', groupName );
        });
    }());

    // -------------------------------------------------------------
    // Magnific Popup
    // -------------------------------------------------------------

    (function () {
      $('.image-link').magnificPopup({

        gallery: {
          enabled: true
        },
        removalDelay: 300, // Delay in milliseconds before popup is removed
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below
        type:'image'
      });
    }());

    // -------------------------------------------------------------
    // STELLAR FOR BACKGROUND SCROLLING
    // -------------------------------------------------------------

    $(document).load(function() {

        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

        }else {
            $.stellar({
                horizontalScrolling: false,
                responsive: true
            });
        }
    });

    // -------------------------------------------------------------
    // WOW JS
    // -------------------------------------------------------------

    (function () {

        new WOW({

            mobile:  false

        }).init();

    }());

    // -------------------------------------------------------------
    // Contact Form
    // -------------------------------------------------------------
    
    $(function () {
        myForm.initForm();
    });

    // -------------------------------------------------------------
    // Google Map
    // -------------------------------------------------------------
    
    $(function initMap() {
            myMap.initMap();
    });

    // -------------------------------------------------------------
    // Navbar Dashboard
    // -------------------------------------------------------------

    $('.show-all').click(function(e){
        e.preventDefault();
        $('.hide').toggleClass('show');
        $('#chevron-nav').toggleClass('fa-chevron-up');
    })
});