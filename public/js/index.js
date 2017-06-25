$(document).ready(function () {
    $('.selectpicker').selectpicker();

    $('#paymentBtn, #calcBtn').attr({'disabled': 'disabled'});

    $('#exCountry').change(function () {
        console.log($("#exCountry").val());
        console.log($("#exCountry option:selected").text());
        console.log($("#exCountry option:selected").attr('data-currency'));
        var currencies = $("#exCountry option:selected").attr('data-currency');
        $('#exCurrency').find('option').remove().end();
        $.each(JSON.parse(currencies), function( index, value ) {
            console.log(value);
            $('#exCurrency')
                .append($("<option></option>")
                    .attr("value",value)
                    .text(value));
        });
        $('#exCurrency').removeAttr('disabled');
        $('.selectpicker').selectpicker('refresh');
    });

    $('#exCountry, #exCurrency').change(function () {
        $('.tempAmount').slideUp(300);
        if ($('#captcha').val().length == 5 && removeComma($('#exAmount').val()) > 9 && $('#exCountry').val() != null && $('#exCurrency').val() != null)
            $('#calcBtn').removeAttr('disabled').removeClass('fanexBtnOutlineOrange').addClass('fanexBtnOrange');
        else {
            $('#paymentBtn').attr({'disabled': 'disabled'});
            $('#calcBtn').attr({'disabled': 'disabled'}).removeClass('fanexBtnOrange').addClass('fanexBtnOutlineOrange');
        }
    });

    $(".numberTextField").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $('#exAmount').blur(function() {
        console.log(accounting.formatMoney($('#exAmount').val()));
        $('#exAmount').val(accounting.formatMoney($('#exAmount').val(), "", 2));
        console.log(removeComma($('#exAmount').val()));
    });
    $('#captcha, #exAmount').keyup(function (e) {
        // $('#exAmount').val(accounting.formatMoney($('#exAmount').val(), "", 2));
        $('.tempAmount').slideUp(300);
        $(this).focus();
        if ($('#captcha').val().length == 5 && removeComma($('#exAmount').val()) > 9 && $('#exCountry').val() != null && $('#exCurrency').val() != null)
            $('#calcBtn').removeAttr('disabled').removeClass('fanexBtnOutlineOrange').addClass('fanexBtnOrange');
        else {
            $('#paymentBtn').attr({'disabled': 'disabled'}).removeClass('fanexBtnOrange').addClass('fanexBtnOutlineOrange');
            $('#calcBtn').attr({'disabled': 'disabled'}).removeClass('fanexBtnOrange').addClass('fanexBtnOutlineOrange');
        }
    });

    //About Page Scroll Bar
    $('html, body, .fanexMotto, .dropdown-menu .inner, textarea').niceScroll({
        cursorcolor: "#000",
        cursoropacitymin: 0.1,
        cursoropacitymax: 0.3,
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: "5px"
    });

    var $iW = $(window).innerWidth();
    if ($iW < 992) {
        $('.bnf-auto-sidebar').insertBefore('.bnf-auto-content');
    } else {
        $('.bnf-auto-sidebar').insertAfter('.bnf-auto-content');
    }
    if ($(window).width() > 993) {
        $('#bnf-sidebar').stick_in_parent({
            "offset_top": 25
        });
        $('#profile-sidebar').stick_in_parent({
            "offset_top": 95
        });
    }
    else {
        $('#bnf-sidebar, #profile-sidebar').trigger("sticky_kit:detach");
    }

    $(window).resize(function () {
        var $iW = $(window).innerWidth();
        if ($iW < 992) {
            $('.bnf-auto-sidebar').insertBefore('.bnf-auto-content');
        } else {
            $('.bnf-auto-sidebar').insertAfter('.bnf-auto-content');
        }
        if ($(window).width() > 993) {
            $('#bnf-sidebar').stick_in_parent({
                "offset_top": 25
            });
            $('#profile-sidebar').stick_in_parent({
                "offset_top": 95
            });
        }
        else {
            $('#bnf-sidebar, #profile-sidebar').trigger("sticky_kit:detach");
        }
    });

    var ttl = readCookie('ttl');

    if (!isNaN(ttl)) {
        var tenMins = new Date().getTime() + ((ttl * 1000) - new Date().getTime());
        $('#countdown').countdown(tenMins, function (event) {
            $(this).html(event.strftime('%M:%S'));
        }).on('finish.countdown', function () {
            $('#countdown').html(timeOut).addClass('alert shake animated');
        });
    }
    else {
        $('#countdown').html(timeOut).addClass('alert shake animated');
    }
});

function removeComma(amount) {
    return parseFloat(amount.replace(/,/g, ''));
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
}

function reloadCaptcha() {
    $('#captcha').val('');
    var captcha = $('.captcha-img');
    var config = captcha.data('refresh-config');
    $.ajax({
        method: 'GET',
        url: '/get_captcha/' + config,
    }).done(function (response) {
        captcha.prop('src', response);
    });
}

function getAmount() {
    $('#mainFormLoader').fadeIn(200);
    setTimeout(function () {
        $.ajax({
            method: 'POST',
            url: '/calculate',
            data: {
                '_token': csrfToken,
                "amount": parseFloat($('#exAmount').val().replace(/,/g, '')),
                "currency": $('#exCurrency').val(),
                "country": $('#exCountry').val(),
                "captcha": $('#captcha').val()
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#calcBtn').attr({'disabled': 'disabled'}).removeClass('fanexBtnOrange').addClass('fanexBtnOutlineOrange');
                reloadCaptcha();
                var json = $.parseJSON(xhr.responseText);
                $(json).each(function (i, val) {
                    $('#mainFormLoader .spinner2').fadeOut(200);
                    $.each(val, function (k, v) {
                        $('#mainFormLoader .errors').fadeIn(200).html(v);
                        setTimeout(function () {
                            $('#mainFormLoader, #mainFormLoader .errors').fadeOut(200);
                            $('#mainFormLoader .spinner2').fadeIn();
                        }, 2000);
                    });
                });
            }
        }).done(function (response) {
            $('#mainFormLoader').fadeOut(200);
            $('#tempAmountCash').text(accounting.formatMoney($('#exAmount').val(), "", 2) + ' ' + $('#exCurrency').val());
            $('#tempAmountCountry').text($("#exCountry option:selected").text());
            $('.calcAmount').text(accounting.formatMoney(response, "", 0));
            $('.tempAmount').slideDown(300);
            $('#calcBtn').attr({'disabled': 'disabled'}).removeClass('fanexBtnOrange').addClass('fanexBtnOutlineOrange');//.trigger( "focusout" );
            $('#paymentBtn').removeAttr('disabled').addClass('fanexBtnOrange').removeClass('fanexBtnOutlineGrey');
            $('#captcha').focus();
            reloadCaptcha();
        });
    }, 1000);
}

/*
  | Change Language Modal
 */
var ModalEffects = (function() {

    function init() {

        var overlay = document.querySelector( '.md-overlay' );

        [].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {

            var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                close = modal.querySelector( '.md-close' );

            function removeModal( hasPerspective ) {
                classie.remove( modal, 'md-show' );

                if( hasPerspective ) {
                    classie.remove( document.documentElement, 'md-perspective' );
                }
            }

            function removeModalHandler() {
                removeModal( classie.has( el, 'md-setperspective' ) );
            }

            el.addEventListener( 'click', function( ev ) {
                classie.add( modal, 'md-show' );
                overlay.removeEventListener( 'click', removeModalHandler );
                overlay.addEventListener( 'click', removeModalHandler );

                if( classie.has( el, 'md-setperspective' ) ) {
                    setTimeout( function() {
                        classie.add( document.documentElement, 'md-perspective' );
                    }, 25 );
                }
            });

            close.addEventListener( 'click', function( ev ) {
                ev.stopPropagation();
                removeModalHandler();
            });
        } );
    }
    init();
})();