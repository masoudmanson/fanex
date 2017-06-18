$(document).ready(function () {
    $('.selectpicker').selectpicker();

    $('#paymentBtn, #calcBtn').attr({'disabled':'disabled'});

    $('#exCountry, #exCurrency').change(function () {
        $('.tempAmount').slideUp(300);
        if($('#captcha').val().length == 5 && $('#exAmount').val() > 9 && $('#exCountry').val() != null && $('#exCurrency').val() != null)
            $('#calcBtn').removeAttr('disabled').removeClass('fanexBtnOutlineOrange').addClass('fanexBtnOrange');
        else {
            $('#paymentBtn').attr({'disabled':'disabled'});
            $('#calcBtn').attr({'disabled':'disabled'}).removeClass('fanexBtnOrange').addClass('fanexBtnOutlineOrange');
        }
    });

    $('#exAmount').keyup(function () {
        $('.tempAmount').slideUp(300);
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

    $('#captcha, #exAmount').keyup(function(e){
        if($('#captcha').val().length == 5 && $('#exAmount').val() > 9 && $('#exCountry').val() != null && $('#exCurrency').val() != null)
            $('#calcBtn').removeAttr('disabled').removeClass('fanexBtnOutlineOrange').addClass('fanexBtnOrange');
        else {
            $('#paymentBtn').attr({'disabled':'disabled'});
            $('#calcBtn').attr({'disabled':'disabled'}).removeClass('fanexBtnOrange').addClass('fanexBtnOutlineOrange');
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
    var tenMins = new Date().getTime() + ((ttl*1000) - new Date().getTime());
    $('#countdown').countdown(tenMins, function (event) {
        $(this).html(event.strftime('%M:%S'));
    }).on('finish.countdown', function () {
        $('#countdown').html('Time Out').addClass('alert shake animated');    });

});

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
//            return null;
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
    setTimeout(function() {
        $.ajax({
            method: 'POST',
            url: '/calculate',
            data: {
                '_token': csrfToken,
                "amount": $('#exAmount').val(),
                "currency": $('#exCurrency').val(),
                "country": $('#exCountry').val(),
                "captcha": $('#captcha').val()
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#calcBtn').attr({'disabled':'disabled'}).removeClass('fanexBtnOrange').addClass('fanexBtnOutlineOrange');
                reloadCaptcha();
                var json = $.parseJSON(xhr.responseText);
                $(json).each(function(i,val) {
                    $('#mainFormLoader .spinner2').fadeOut(200);
                    $.each(val, function (k, v) {
                        $('#mainFormLoader .errors').fadeIn(200).html(v);
                        setTimeout(function() {
                            $('#mainFormLoader, #mainFormLoader .errors').fadeOut(200);
                            $('#mainFormLoader .spinner2').fadeIn();
                        }, 2000);
                    });
                });
            }
        }).done(function (response) {
            $('#mainFormLoader').fadeOut(200);
            $('#tempAmountCash').text(accounting.formatMoney($('#exAmount').val(), "", 2) + ' ' + $('#exCurrency').val() + 's');
            $('#tempAmountCountry').text($('#exCountry').val());
            $('.calcAmount').text(accounting.formatMoney(response, "", 0));
            $('.tempAmount').slideDown(300);
            $('#paymentBtn').removeAttr('disabled');
            reloadCaptcha();
        });
    }, 1000);
}
