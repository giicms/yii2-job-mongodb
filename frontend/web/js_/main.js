/*menu responsive */
(function (window, document, undefined)
{

    // helper functions

    var trim = function (str)
    {
        return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g, '');
    };

    var hasClass = function (el, cn)
    {
        return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
    };

    var addClass = function (el, cn)
    {
        if (!hasClass(el, cn)) {
            el.className = (el.className === '') ? cn : el.className + ' ' + cn;
        }
    };

    var removeClass = function (el, cn)
    {
        el.className = trim((' ' + el.className + ' ').replace(' ' + cn + ' ', ' '));
    };

    var hasParent = function (el, id)
    {
        if (el) {
            do {
                if (el.id === id) {
                    return true;
                }
                if (el.nodeType === 9) {
                    break;
                }
            }
            while ((el = el.parentNode));
        }
        return false;
    };

    // normalize vendor prefixes

    var doc = document.documentElement;

    var transform_prop = window.Modernizr.prefixed('transform'),
            transition_prop = window.Modernizr.prefixed('transition'),
            transition_end = (function () {
                var props = {
                    'WebkitTransition': 'webkitTransitionEnd',
                    'MozTransition': 'transitionend',
                    'OTransition': 'oTransitionEnd otransitionend',
                    'msTransition': 'MSTransitionEnd',
                    'transition': 'transitionend'
                };
                return props.hasOwnProperty(transition_prop) ? props[transition_prop] : false;
            })();

    window.App = (function ()
    {

        var _init = false, app = {};

        var inner = document.getElementById('inner-wrap'),
                nav_open = false,
                nav_class = 'js-nav';


        app.init = function ()
        {
            if (_init) {
                return;
            }
            _init = true;

            var closeNavEnd = function (e)
            {
                if (e && e.target === inner) {
                    document.removeEventListener(transition_end, closeNavEnd, false);
                }
                nav_open = false;
            };

            app.closeNav = function ()
            {
                if (nav_open) {
                    // close navigation after transition or immediately
                    var duration = (transition_end && transition_prop) ? parseFloat(window.getComputedStyle(inner, '')[transition_prop + 'Duration']) : 0;
                    if (duration > 0) {
                        document.addEventListener(transition_end, closeNavEnd, false);
                    } else {
                        closeNavEnd(null);
                    }
                }
                removeClass(doc, nav_class);
            };

            app.openNav = function ()
            {
                if (nav_open) {
                    return;
                }
                addClass(doc, nav_class);
                nav_open = true;
            };

            app.toggleNav = function (e)
            {
                if (nav_open && hasClass(doc, nav_class)) {
                    app.closeNav();
                } else {
                    app.openNav();
                }
                if (e) {
                    e.preventDefault();
                }
            };

            // open nav with main "nav" button
            document.getElementById('nav-open-btn').addEventListener('click', app.toggleNav, false);

            // close nav with main "close" button
            document.getElementById('nav-close-btn').addEventListener('click', app.toggleNav, false);

            // close nav by touching the partial off-screen content
            document.addEventListener('click', function (e)
            {
                if (nav_open && !hasParent(e.target, 'nav')) {
                    e.preventDefault();
                    app.closeNav();
                }
            },
                    true);

            addClass(doc, 'js-ready');

        };

        return app;

    })();

    if (window.addEventListener) {
        window.addEventListener('DOMContentLoaded', window.App.init, false);
    }
	
	$('.nav-responsive .menutem').click(function(){
        $('.nav-responsive .menutem').removeClass('is-active');
        $(this).addClass('is-active')
    })

})(window, window.document);


//slide partner

$(document).ready(function ($) {
    $("#owl-example").owlCarousel({
        items: 4,
        autoPlay: true,
        responsive: true
    });
});

//scroll to top
$(document).ready(function () {

    //Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.scroll-top').fadeIn();
        } else {
            $('.scroll-top').fadeOut();
        }
    });

    //Click event to scroll to top
    $('#Scrolltop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });

});

$(document).ready(function () {

    $('#basic2').selectpicker({
        liveSearch: true,
        maxOptions: 1
    });
});
$(document).ready(function () {

    $('#basic1').selectpicker({
        liveSearch: true,
        maxOptions: 1
    });
});
$(document).ready(function () {

    $('#basic3').selectpicker({
        liveSearch: true,
        maxOptions: 1
    });

});
$(function () {
    $('.datetimepicker').datepicker({
        //beforeShowDay: $.datepicker.noWeekends,
        minDate: 1,
        dateFormat: 'dd-mm-yy'
    });
});


$('.scroll').mCustomScrollbar({
    theme: "dark-3",
    scrollTo: "bottom"
});


$(function () {
    $('#job-deadline').datepicker({
        //beforeShowDay: $.datepicker.noWeekends,
        minDate: 1,
        dateFormat: 'dd/mm/yy'
    });
});

$(function () {
    $('.datepicker').datepicker({
        //beforeShowDay: $.datepicker.noWeekends,
        minDate: 1,
        dateFormat: 'dd/mm/yy',
    });
    $('.datepicker2').datepicker({
        //beforeShowDay: $.datepicker.noWeekends,
        dateFormat: 'dd/mm/yy',
        monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
        yearRange: "1960:2010",
        changeMonth: true,
        changeYear: true
    });
});

$(".scroll-notify").mCustomScrollbar({
    theme: "dark-3",
    callbacks: {
        onTotalScrollOffset: 20,
        onTotalScroll: function () {
            var page = $('#page-notify').val();
            var url = '/ajax/notifylist?page=' + page
            $('#loadding').html('<p style="padding:10px; text-align: center">Loading...</p>');
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data)
                {
                    $('#page-notify').val(data.page);
                    for (i = 0; i < data.data.length; i++) {
                        var item = data.data[i];
                        $('.notify-bar').append('<li><a href="' + item.url + '"><img class="avatar-32" src="' + item.avatar + '"> <div class="not-inf">' + item.content + '<p><i class="fa fa-commenting"></i><small>' + item.created_at + '</small></p></div></a></li>')
                    }
                    $('#loadding').html('');
                },
                error: function () {
                    $('#loadding').html('');
                }
            });
        }
    }

});
$(document).on('click', '.notification', function (event) {
    event.preventDefault();
    $.ajax({
        url: '/client/notify',
        type: 'post',
        success: function (data) {
            $('.notify-active').html('');
            if (data) {
                $('.notify-bar').prepend('<li><a href="' + data.url + '"><img class="avatar-32" src="' + data.avatar + '"> <div class="not-inf">' + data.content + '<p><i class="fa fa-commenting"></i><small>' + data.created_at + '</small></p></div></a></li>')

            }
        }
    });

});

$(".scroll-messages").mCustomScrollbar({
    theme: "dark-3",
    callbacks: {
        onTotalScrollOffset: 20,
        onTotalScroll: function () {
            var page = $('#page-messages').val();
            var url = '/messages/list?page=' + page
            $('#load-messages').html('<p style="padding:10px; text-align: center">Loading...</p>');
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data)
                {
                    $('#page-messages').val(data.page);
                    for (i = 0; i < data.data.length; i++) {
                        var item = data.data[i];
                        $('.messages-bar').append('<li><a href="' + item.url + '"><img class="avatar-32" src="' + item.avatar + '"> <div class="not-inf">' + item.content + '<p><i class="fa fa-commenting"></i><small>' + item.created_at + '</small></p></div></a></li>')
                    }
                    $('#load-messages').html('');
                },
                error: function () {
                    $('#load-messages').html('');
                }
            });
        }
    }

});
$(".user-messages").mCustomScrollbar({
    theme: "dark-3",
    callbacks: {
        onTotalScrollOffset: 20,
        onTotalScroll: function () {
            var page = $('#page-index-messages').val();
            var actor = $('#actor').val();
            var url = '/messages/list?actor=' + actor + '&page=' + page
            $('#load-index-messages').html('<p style="padding:10px; text-align: center">Loading...</p>');
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data)
                {
                    $('#page-index-messages').val(data.page);
                    for (i = 0; i < data.data.length; i++) {
                        var item = data.data[i];
                        $('.list-messages').append('<li><a href="' + item.url + '"><img class="avatar-32" src="' + item.avatar + '"> <div class="not-inf">' + item.content + '<p><i class="fa fa-commenting"></i><small>' + item.created_at + '</small></p></div></a></li>')
                    }
                    $('#load-index-messages').html('');
                },
                error: function () {
                    $('#load-index-messages').html('');
                }
            });
        }
    }

});


$(".btn-messages").click(function (event) {
    event.preventDefault();
    $.ajax({
        url: '/messages/active',
        type: 'post',
        success: function (data) {
            $('.mact').html('');
            if (data) {
                for (i = 0; i < data.length; i++) {
                    var item = data[i];
                    $('.messages-bar').prepend('<li><a href="' + item.url + '"><img class="avatar-32" src="' + item.avatar + '"> <div class="not-inf">' +item.user_name+' đã nhắn tin "'+ item.content + '".<p><i class="fa fa-commenting"></i><small>' + item.created_at + '</small></p></div></a></li>');
                }
            }
        }
    });

});
$(document).ready(function () {
    tinymce.init({
        selector: '.des-editor',
        height: 500,
        plugins: [
            'advlist autolink autosave autoresize link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker  textpattern'
        ],
        toolbar1: 'newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect',
        toolbar2: 'cut copy paste | outdent indent blockquote | undo redo | insertdatetime preview | forecolor backcolor | table ',
        menubar: false,
        toolbar_items_size: 'small',
        content_css: [
            '//www.tinymce.com/css/codepen.min.css'
        ],
    });
});
$('.scrollTo').mCustomScrollbar('scrollTo', 'bottom');