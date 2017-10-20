/*
 * Plugin Name: Themeum Core
 * Plugin URI: http://www.themeum.com/item/core
 * Author: Themeum
 * Author URI: http://www.themeum.com
 * License - GNU/GPL V2 or Later
 * Description: Themeum Core is a required plugin for this theme.
 * Version: 1.0
 */

jQuery(document).ready(function ($) {
    'use strict';



    $('select.select2').select2({
        minimumResultsForSearch: -1
    });


    function formatRepo(repo) {
        if (repo.loading)
            return repo.text;

        var markup = '<div class="select2-result-repository">' + repo.name + '</div>';

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.name || repo.text;
    }

    var app = $(".thm-fs-place").select2({
        ajax: {
            url: thm_flight.ajax_url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    query: params.term, // search term
                    action: 'get_places_by_query',
                };
            },
            processResults: function (data, params) {
                var places = [];

                $.each(data.Places, function (key, value) {
                    var place = {
                        id: value.PlaceId,
                        name: value.PlaceName + " (" + value.CountryName + ")"
                    };

                    places.push(place);
                });

                return {
                    results: places,
                };
            },
            cache: true
        },
        // placeholder: "City or Airport",
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 3,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });



    /*var $ajax = $(".thm-fs-place");




     function formatRepo (repo) {
     if (repo.loading) return repo.text;

     var markup = "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

     return markup;
     }

     function formatRepoSelection (repo) {
     return repo.full_name || repo.text;
     }

     $ajax.select2({
     ajax: {
     url: "https://api.github.com/search/repositories",
     dataType: 'json',
     delay: 250,
     data: function (params) {
     return {
     q: params.term, // search term
     };
     },
     processResults: function (data, params) {

     console.log(data);

     return {
     results: data.items,
     };
     },
     cache: true
     },
     escapeMarkup: function (markup) { return markup; },
     minimumInputLength: 1,
     templateResult: formatRepo,
     templateSelection: formatRepoSelection
     });*/














    $('.thm-date-picker').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0
    });

    $('.thm-date-time-picker').each(function () {

        var current = $(this).val();

        $(this).datetimepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0
        }).datetimepicker('setDate', current);
    });


    // Home Slider

    function doAnimations(elems) {
        var animEndEv = 'webkitAnimationEnd animationend';

        elems.each(function () {
            var $this = $(this),
                    $animationType = $this.data('animation');
            $this.addClass($animationType).one(animEndEv, function () {
                $this.removeClass($animationType);
            });
        });
    }
    var $myCarousel = $('.home-two-crousel');
    var $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
    $myCarousel.carousel();
    doAnimations($firstAnimatingElems);
    $myCarousel.on('slide.bs.carousel', function (e) {
        var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
        doAnimations($animatingElems);
    });


    // prettySocial
    $('.prettySocial').prettySocial();

    //Animated Number
    $('.themeum-counter-number').each(function () {
        var $this = $(this);
        $({Counter: 0}).animate({Counter: $this.data('digit')}, {
            duration: $this.data('duration'),
            step: function () {
                $this.text(Math.ceil(this.Counter));
            }
        });
    });

    new WOW().init



    var $partnercarosuel = $('.themeum-partner-carosuel');
    $partnercarosuel.owlCarousel({
        loop: true,
        dots: false,
        nav: false,
        rtl: true,
        margin: 140,
        autoplay: false,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        autoHeight: false,
        lazyLoad: true,
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });



    //Start Photos Gallery
    $('a[href="#roomtype"], a[href="#gallery"]').on('shown.bs.tab', function () {
        setTimeout(function () {
            initialize_owl($('.photos-gallery'));
        }, 300);
    })

    function initialize_owl(gallery) {
        gallery.owlCarousel({
            loop: true,
            nav: false,
            rtl: true,
            autoplay: true,
            items: 1
        });
    }
    function destroy_owl(gallery) {
        if (gallery.data('owlCarousel')) {
            gallery.data('owlCarousel').destroy();
        }
    }
    //End Photos Gallery

    var $featurecarosuel = $('.themeum-feature-carosuel');
    $featurecarosuel.owlCarousel({
       loop:true,
       dots:false,
       nav:false,
       rtl: true,
       margin:30,
       autoplay:true,
       autoplayTimeout:3000,
       autoplayHoverPause:true,
       autoHeight: false,
       lazyLoad:true,
       responsive:{
           0:{
               items:1
           },
           600:{
               items:1
           },
           1000:{
               items:5
           }
       },
       onInitialized: function() {
           $('.owl-item.active').first().addClass('last-owl-active-item');
       }
   });

    $featurecarosuel.on('translated.owl.carousel', function (event) {
    	console.log(event);
    	$(event.target).find('.last-owl-active-item').removeClass('last-owl-active-item');
        $(event.target).find('.active').first().addClass('last-owl-active-item');
    });

    if ($(".tour-video").length > 0) {
        $(".tour-video a").magnificPopup({
            disableOn: 0,
            type: 'iframe',
            mainClass: 'mfp-fade',
            rtl:true,
            removalDelay: 300,
            preloader: false,
            fixedContentPos: false,
        });
    }

    // Popup Video
    if ($('.popup-video').length > 0) {
        $('.popup-video').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            rtl: true,
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    }

    //popup
    $('.plus-icon').magnificPopup({
        type: 'image',
        mainClass: 'mfp-with-zoom',
        zoom: {
            enabled: true,
            duration: 300,
            easing: 'ease-in-out',
            opener: function (openerElement) {
                return openerElement.next('img') ? openerElement : openerElement.find('img');
            }
        },
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        }
    });
    $('.plus-icon').on('click', function () {
        $('html').css('overflow', 'inherit');
    });


    $('.buynowbtn').magnificPopup({
        type: 'inline',
        removalDelay: 500,
        callbacks: {
            beforeOpen: function () {
                this.st.mainClass = this.st.el.attr('data-effect');
            }
        },
        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    });


    (function () {
        var bsa = document.createElement('script');
        bsa.type = 'text/javascript';
        bsa.async = true;
        bsa.src = '//s3.buysellads.com/ac/bsa.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(bsa);
    })();

    //  end popup




});


jQuery(document).ready(function ($) {

    var Flight = {};

    Flight.renderTo = function (from, to) {
        var thm_flights = JSON.parse(localStorage.getItem('thm_flights'));
        $('ul#all-flights').addClass('active');
        for (var i = from; i <= to; i++) {
            var flightContainer = $('ul#all-flights'),
                    flightData = {
                        position: (i - from),
                        data: thm_flights[i]
                    };

            var request = $.ajax({
                url: thm_flight.ajax_url,
                method: "POST",
                data: {
                    action: 'get_flight_html',
                    flight: flightData
                },
                // dataType: "html"
            });

            request.done(function (data) {

                var liItem = flightContainer.find('li[data-pos="' + $(data).data('pos') + '"]');

                liItem.addClass('active');
                liItem.html(data);
            });
        }
    };

    Flight.pagination = function () {
        var thm_flights = JSON.parse(localStorage.getItem('thm_flights')),
                totalFlights = thm_flights.length,
                numberOfPage = Math.floor(totalFlights / 10),
                dotDot = false,
                htmlOutput = '',
                paginationContainer = $('#flight-pagination');

        if (thm_flights.length % 10) {
            numberOfPage++;
        }

        if (numberOfPage > 5) {
            dotDot = true;
        }


        htmlOutput += '<li><a href="#" data-type="prev" class="flight-next-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';

        for (var i = 1; i <= numberOfPage; i++) {
            if (i == 1) {
                htmlOutput += '<li><a href="#" data-page="' + i + '" class="flight-pagenum active">' + i + '</a></li>';
            } else if (numberOfPage == i) {
                htmlOutput += '<li><a href="#" data-page="' + i + '" class="flight-pagenum thm-last-item">' + i + '</a></li>';
            } else {
                htmlOutput += '<li><a href="#" data-page="' + i + '" class="flight-pagenum">' + i + '</a></li>';
            }
        }

        htmlOutput += '<li><a href="#" data-type="next" class="flight-next-prev"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';

        paginationContainer.html(htmlOutput);
    };

    $('ul#all-flights').on('click', '.thm-show-more', function (e) {
        e.preventDefault();

        var flightDetails = $(this).parents('.thm-flight').find('.thm-flight-details'),
                showMore = $(this).parents('.thm-flight').find('.thm-show-more-main');

        showMore.toggleClass('active');
        if (showMore.find('i').hasClass('fa-caret-right')) {
            showMore.find('i').removeClass('fa-caret-right');
            showMore.find('i').addClass('fa-caret-down');
        } else {
            showMore.find('i').removeClass('fa-caret-down');
            showMore.find('i').addClass('fa-caret-right');
        }
        flightDetails.toggleClass('active');
    });

    $('#flight-pagination').on('click', 'a.flight-pagenum', function (e) {
        e.preventDefault();

        $('html, body').animate({
            scrollTop: $(".thm-tk-search").offset().top - 80
        }, 500);

        var self = this;

        setTimeout(function () {
            var pageNumber = $(self).data('page'),
                    form = (parseInt(pageNumber) * 10) - 10,
                    to = (parseInt(pageNumber) * 10) - 1,
                    thm_flights = JSON.parse(localStorage.getItem('thm_flights'));

            if ($(self).hasClass('thm-last-item')) {
                to = to - (10 - (thm_flights.length % 10));
            }

            $('ul#all-flights li').each(function () {
                $(this).html('');
                $(this).removeClass('active');
            });

            Flight.renderTo(form, to);

            $('#flight-pagination li a.active').removeClass('active');
            $(self).addClass('active');
        }, 600);

    });

    $('#flight-pagination').on('click', 'a.flight-next-prev', function (e) {

        e.preventDefault();

        var type = $(this).data('type');



        if (type == 'next') {
            if (!$(this).is($('#flight-pagination li a.active').parent().next().find('a'))) {
                $('#flight-pagination li a.active').parent().next().find('a').trigger('click');
            }

        } else if (type == 'prev') {
            if (!$(this).is($('#flight-pagination li a.active').parent().prev().find('a'))) {
                $('#flight-pagination li a.active').parent().prev().find('a').trigger('click');
            }
        }
    });

    $('#thm-tk-flights-search-form').on('submit', function (e) {
        e.preventDefault();

        $('html, body').animate({
            scrollTop: $(".thm-tk-search").offset().top - 80
        }, 500);

        $('ul#all-flights li').each(function () {
            $(this).html('');
            $(this).removeClass('active');
        });

        $('#flight-pagination').html('');

        $('.thm-flight-results .thm-titlestandardstyle').removeClass('active');

        $('.thm-flight-alert').removeClass('active');
        $('.thm-flight-alert-no-result').removeClass('active');

        $('.thm-flight-results').addClass('active');

        $('.flight-loader').addClass('active');

        var data = $(this).serialize();

        var request = $.ajax({
            url: thm_flight.ajax_url,
            method: "POST",
            data: {
                action: 'get_flight_data',
                search: data
            },
            dataType: "json"
        });

        request.done(function (data, textStatus, jqXHR) {
            $('.flight-loader').removeClass('active');

            if (data) {
                localStorage.setItem('thm_flights', JSON.stringify(data));

                $('.thm-titlestandardstyle > .thm-flight-count').html(data.length);

                $('.thm-flight-results .thm-titlestandardstyle').addClass('active');




                Flight.renderTo(0, 9);
                Flight.pagination();
            } else {
                $('.thm-flight-alert-no-result').addClass('active');
            }

            if (textStatus != 'success') {
                $('.thm-flight-alert').addClass('active');
            }

        });

        request.fail(function (jqXHR) {
            $('.flight-loader').removeClass('active');
            $('.thm-flight-alert').addClass('active');
        });

        /*$('.thm-titlestandardstyle > .thm-flight-count').html(data.length);

         $('.thm-flight-results .thm-titlestandardstyle').addClass('active');

         $('.flight-loader').removeClass('active');
         Flight.renderTo(0, 9);
         Flight.pagination();*/
    });


    




});

var submitPaymentForm = function(payData)
    {

    var data = {
        'action':'strip_payment_submit',
        'data' : payData
    };

    jQuery.ajax({
        url: thm_flight.ajax_url,
        type: 'POST',
        dataType: 'json',
        data: data,
    })
    .done(function(data) {
        console.log(data);
        if (data.status == true) {
            window.location = data.redirect;
        }
    })
    .fail(function() {
        console.log("error");
    });
};
