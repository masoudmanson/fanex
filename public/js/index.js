$(document).ready(function() {
    $('.selectpicker').selectpicker();
    $('#exCountry').val('').focus();
    $('.selectpicker').selectpicker('refresh');
    $('.disabledForm').
        attr({'disabled': 'disabled', 'title': indexFormCountry});

    $('#pdf-test').on('click', function(e) {
        e.preventDefault();
        console.log('Getting ready to print the document.');
        if (!window.print) {
            alert('You need NS4.x to use this print button!');
            return;
        }

        console.log('Hiding extra stuff from page.');

        $('#bnf-sidebar').hide();
        $('.dash-title').hide();
        $('.dash-subtitle').hide();
        $('.not-print').hide();
        $('.invoice-print').hide();

        window.print();

        console.log('Displaying hided stuff again.');

        $('#bnf-sidebar').fadeIn(300);
        $('.dash-title').fadeIn(300);
        $('.dash-subtitle').fadeIn(300);
        $('.not-print').fadeIn(300);
        $('.invoice-print').fadeIn(300);

    });

    $('#exCountry').change(function() {
        var currencies = $('#exCountry option:selected').attr('data-currency');
        $('#exCurrency').find('option').remove().end();
        $.each(JSON.parse(currencies), function(index, value) {
            $('#exCurrency').
                append($('<option data-sign=\'' + value.sign + '\'></option>').
                    attr('value', index).
                    text(value.name));
        });
        $('.fanexInput').removeClass('fanex-border');
        $('#exCurrency').addClass('fanex-border').focus();
        $('.exCurrency').removeAttr('disabled');
        $('.disabledForm').attr({'title': indexFormCurrency});
        $('.selectpicker').selectpicker('refresh');
    });

    $('#exCurrency').change(function() {
        $('.fanexInput').removeClass('fanex-border');
        $('#exAmount').removeAttr('disabled').addClass('fanex-border').focus();
        $('.disabledForm').attr({'title': indexFormAmount});
    });

    $('#exAmount').keyup(function() {
        if ($('#exAmount').val().length > 1) {
            $('#exAmount').removeClass('fanex-border');
            $('#captcha').removeAttr('disabled').addClass('fanex-border');
            $('.disabledForm').attr({'title': indexFormCaptcha});
        }
        else {
            document.onkeyup = null;
            $('#captcha').removeClass('fanex-border');
            $('#exAmount').addClass('fanex-border');
            $('#captcha').
                attr({'disabled': 'disabled', 'title': indexFormAmount});
        }
    });

    $('#captcha').keyup(function() {
        if ($(this).val().length == 5) {
            $('#captcha').removeClass('fanex-border');
            $('#calcBtn').
                removeAttr('disabled').
                removeClass('fanexBtnOutlineOrange').
                addClass('fanexBtnOrange');
            $('.disabledForm').attr({'title': indexFormCalculate});
            document.onkeyup = function(event) {
                if (event.which == 13 || event.keyCode == 13) {
                    $('#calcBtn').click();
                }
            };
        }
        else {
            document.onkeyup = null;
            $('#captcha').addClass('fanex-border');
            $('#calcBtn').
                attr({'disabled': 'disabled', 'title': indexFormCaptcha});
        }
    });

    $('#exCountry, #exCurrency').change(function() {
        $('.tempAmount').slideUp(300);

        var currency = $('#exCurrency').val();
        var amount = 0;
        if (currency === 'EUR' || currency === 'USD') {
            amount = Number($('#exAmount').unmask()) / 100;
        }
        else if (currency === 'TRY') {
            amount = Number($('#exAmount').unmask());
        }

        if ($('#captcha').val().length == 5 && amount > AMOUNT_LIMIT_MIN &&
            $('#exCountry').val() != null && $('#exCurrency').val() != null) {
            $('#calcBtn').
                removeAttr('disabled').
                removeClass('fanexBtnOutlineOrange').
                addClass('fanexBtnOrange');
            $('.disabledForm').attr({'title': indexFormCalculate});
            document.onkeyup = function(event) {
                if (event.which == 13 || event.keyCode == 13) {
                    $('#calcBtn').click();
                }
            };
        }
        else {
            $('#paymentBtn').
                attr({'disabled': 'disabled'}).
                removeClass('fanexBtnOrange').
                addClass('fanexBtnOutlineOrange');
            $('#calcBtn').
                attr({'disabled': 'disabled'}).
                removeClass('fanexBtnOrange').
                addClass('fanexBtnOutlineOrange');
            document.onkeyup = null;
        }

        $('#exAmount').val('').unpriceFormat();

        var sign = $('#exCurrency option:selected').attr('data-sign');

        if (currency === 'EUR' || currency === 'USD') {
            $('#exAmount').priceFormat({
                limit: 7,
                centsLimit: 2,
                prefix: sign + ' ',
            });
        }
        else if (currency === 'TRY') {
            $('#exAmount').priceFormat({
                limit: 5,
                centsLimit: 0,
                prefix: sign + ' ',
            });
        }

        $('.selectpicker').selectpicker('refresh');
    });

    $('#captcha, #exAmount').keyup(function(e) {
        $('.tempAmount').slideUp(300);

        var currency = $('#exCurrency').val();
        var amount = 0;
        if (currency === 'EUR' || currency === 'USD') {
            amount = Number($('#exAmount').unmask()) / 100;
        }
        else if (currency === 'TRY') {
            amount = Number($('#exAmount').unmask());
        }

        $(this).focus();
        if ($('#captcha').val().length == 5 && amount > AMOUNT_LIMIT_MIN &&
            $('#exCountry').val() != null && $('#exCurrency').val() != null) {
            $('#calcBtn').
                removeAttr('disabled').
                removeClass('fanexBtnOutlineOrange').
                addClass('fanexBtnOrange');
            document.onkeyup = function(event) {
                if (event.which == 13 || event.keyCode == 13) {
                    $('#calcBtn').click();
                }
            };
        }
        else {
            $('#paymentBtn').
                attr({'disabled': 'disabled'}).
                removeClass('fanexBtnOrange').
                addClass('fanexBtnOutlineOrange');
            $('#calcBtn').
                attr({'disabled': 'disabled'}).
                removeClass('fanexBtnOrange').
                addClass('fanexBtnOutlineOrange');
            document.onkeyup = null;
        }
    });

    var nice = $('html, body, .fanexMotto, .dropdown-menu .inner, textarea').
        niceScroll({
            cursorcolor: '#000',
            cursoropacitymin: 0.1,
            cursoropacitymax: 0.3,
            cursorwidth: '5px',
            cursorborder: 'none',
            cursorborderradius: '5px',
            horizrailenabled: false,
        });

    $('#accordion').on('shown.bs.collapse', function() {
        $(this).addClass('opened');
        nice.resize();
    });

    var $iW = $(window).innerWidth();
    if ($iW < 992) {
        $('.bnf-auto-sidebar').insertBefore('.bnf-auto-content');
    }
    else {
        $('.bnf-auto-sidebar').insertAfter('.bnf-auto-content');
    }
    if ($(window).width() > 993) {
        $('#bnf-sidebar').stick_in_parent({
            'offset_top': 25,
        });
        $('#profile-sidebar').stick_in_parent({
            'offset_top': 75,
        });
    }
    else {
        $('#bnf-sidebar, #profile-sidebar').trigger('sticky_kit:detach');
    }

    $(window).resize(function() {
        var $iW = $(window).innerWidth();
        if ($iW < 992) {
            $('.bnf-auto-sidebar').insertBefore('.bnf-auto-content');
        }
        else {
            $('.bnf-auto-sidebar').insertAfter('.bnf-auto-content');
        }
        if ($(window).width() > 993) {
            $('#bnf-sidebar').stick_in_parent({
                'offset_top': 0,
            });
            $('#profile-sidebar').stick_in_parent({
                'offset_top': 75,
            });
        }
        else {
            $('#bnf-sidebar, #profile-sidebar').trigger('sticky_kit:detach');
        }
    });

    $('a.accordion-toggle').click(function(e) {
        e.preventDefault();
    });

    $('.search-command').on('click', function() {
        var search_key = $('.search-input').val();
        var search_command = $(this).attr('data-command');

        if (search_key.search(":") < 0) {
            $('.search-input').val(' ');
            search_key = "";
        }

        if (search_key.search(search_command) < 0) {
            var new_search_keyword = search_key + ' ' + search_command;
            $('.search-input').val(new_search_keyword);
            setCaretPosition('transaction-search', new_search_keyword.length);
            setCaretPosition('beneficiary-search', new_search_keyword.length);
        }
        else {
            // var myString = search_key;
            // var myRegexp = /(?:(name|transaction|account|amount|date):)([^:
            // ]+(?:\s+[^: ]+\b(?!:))*)/gi; var match =
            // myRegexp.exec(myString); var matches = new Array();
            // matches.push({"key" : match[1], "value" : match[2], "index" :
            // match.index}); while (match != null) { console.log(match[0]);
            // match = myRegexp.exec(myString); if(match) matches.push({"key" :
            // match[1], "value" : match[2], "index" : match.index}); } //
            // while () { //     // matched text: match[0] //     // match
            // start: match.index //     // capturing group n: match[n] //
            // console.log(match[0]); //     match = myRegexp.exec(myString);
            // //     matches.push(match); // } console.log(matches); matches.each(function(index ) { console.log(index); }); console.log(jQuery.inArray( "name", matches ));

            setCaretPosition('transaction-search',
                search_key.search(search_command) + search_command.length);
            setCaretPosition('beneficiary-search',
                search_key.search(search_command) + search_command.length);
        }
    });
});

$(document).on('keydown', '.numberTextField', function(e) {
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
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
        (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

$(document).on('click','#ajax-transaction-list .status-handler.collapsed:not(.help-link)',function() {
    var trans_id = $(this).attr('data-id');
    $('.status-container-' + trans_id + ' .ajax-status').
        html(
            '<div class="spinner3"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
    $.ajax({
        method: 'get',
        url: '/transaction/status/update/' + trans_id,
        data: {
            '_token': csrfToken,
            'X-CSRF-TOKEN': csrfToken,
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError);
        },
    }).done(function(response) {
        $(this).parent().find('.ajax-status').attr('class',
            function(i, c) {
                return c.replace(/(^|\s)fanex-text-\S+/g, '');
            });
        var result = $.parseJSON(response);
        var bank = result.bank_status;
        var fanex = result.fanex_status;
        var upt = result.upt_status;
        $('#header-status-' + trans_id).
            html('<span class="acc-status fanex-text-' +
                result.upt_status +
                ' ajax-status"><i class="icon-' + result.upt_status +
                '"></i><span class="hidden-xs">' + statuses[upt] +
                '</span></span>');
        $('#bank-status-' + trans_id).
            html(statuses[bank]).
            addClass('fanex-text-' + statuses[bank].toLowerCase());
        $('#fanex-status-' + trans_id).
            html(statuses[fanex]).
            addClass('fanex-text-' + statuses[fanex].toLowerCase());
        $('#upt-status-' + trans_id).
            html(statuses[upt]).
            addClass('fanex-text-' + statuses[upt].toLowerCase());
    }).fail(function() {
        console.log('There is problem in Loading the new statuses');
    });
});

function setCaretPosition(elemId, caretPos) {
    var elem = document.getElementById(elemId);

    if (elem != null) {
        if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            if (elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            else {
                elem.focus();
            }
        }
    }
}

function createSelection(field, start, end) {
    field = document.getElementById(field);
    if (field.createTextRange) {
        var selRange = field.createTextRange();
        selRange.collapse(true);
        selRange.moveStart('character', start);
        selRange.moveEnd('character', end - start);
        selRange.select();
    }
    else if (field.setSelectionRange) {
        field.setSelectionRange(start, end);
    }
    else if (field.selectionStart) {
        field.selectionStart = start;
        field.selectionEnd = end;
    }
    field.focus();
}

function search(keyword) {
    if (keyword.length == 0) {
        $('#mainFormLoader').fadeIn(200);
        x = $.ajax({
            method: 'get',
            url: '/profile',
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            },
        }).done(function(response) {
            $('#mainFormLoader').fadeOut(200);
            $('#ajax-transaction-list').html(response);
        });
    }
    else if (keyword.length >= 1) {
        $('#mainFormLoader').fadeIn(200);
        $.ajax({
            method: 'post',
            url: '/search/transaction',
            data: {
                '_token': csrfToken,
                'X-CSRF-TOKEN': csrfToken,
                'keyword': keyword,
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            },
        }).done(function(response) {
            $('#mainFormLoader').fadeOut(200);

            keyword = keyword.replace(/(\s+)/, '(<[^>]+>)*$1(<[^>]+>)*');
            var pattern = new RegExp('([^\/])(' + keyword + ')([^\?])', 'gi');
            response = response.replace(pattern, '$1<mark>$2</mark>$3');
            response = response.replace(
                /(<mark>[^<>]*)((<[^>]+>)+)([^<>]*<\/mark>)/,
                '$1</mark>$2<mark>$4');

            $('#ajax-transaction-list').html(response);
        });
    }
}

function getAmount() {
    var currency = $('#exCurrency').val();
    var amount = 0;
    if (currency === 'EUR' || currency === 'USD') {
        amount = Number($('#exAmount').unmask()) / 100;
    }
    else if (currency === 'TRY') {
        amount = Number($('#exAmount').unmask());
    }

    $('#mainFormLoader').fadeIn(200);
    $.ajax({
        method: 'POST',
        url: '/calculate',
        data: {
            '_token': csrfToken,
            'X-CSRF-TOKEN': csrfToken,
            // "amount": parseFloat($('#exAmount').maskMoney('unmasked')[0]),
            // "amount": $('#exAmount').val(),
            'amount': amount,
            'currency': $('#exCurrency').val(),
            'country': $('#exCountry').val(),
            'captcha': $('#captcha').val(),
        },
        error: function(xhr, ajaxOptions, thrownError) {
            document.onkeyup = null;
            $('#calcBtn').
                attr({'disabled': 'disabled'}).
                removeClass('fanexBtnOrange').
                addClass('fanexBtnOutlineOrange');
            reloadCaptcha();
            var json = $.parseJSON(xhr.responseText);
            $(json).each(function(i, val) {
                $('#mainFormLoader .spinner2').fadeOut(200);
                $.each(val, function(k, v) {
                    $('#mainFormLoader .errors').fadeIn(200).html(v);
                    setTimeout(function() {
                        $('#mainFormLoader, #mainFormLoader .errors').
                            fadeOut(200);
                        $('#mainFormLoader .spinner2').fadeIn();
                    }, 2000);
                });
            });
        },
    }).done(function(response) {
        $('.disabledForm').removeAttr('title');
        $('#paymentBtn').attr({'title': indexFormPay});

        var currency = $('#exCurrency').val();
        $('#mainFormLoader').fadeOut(200);
        if (currency === 'EUR' || currency === 'USD') {
            $('#tempAmountCash').
                text(accounting.formatMoney($('#exAmount').val(), '', 2) + ' ' +
                    $('#exCurrency option:selected').text());
        }
        else {
            $('#tempAmountCash').
                text(accounting.formatMoney($('#exAmount').val(), '', 0) + ' ' +
                    $('#exCurrency option:selected').text());
        }
        $('#tempAmountCountry').text($('#exCountry option:selected').text());
        $('.calcAmount').text(accounting.formatMoney(response, '', 0));
        $('.tempAmount').slideDown(300);
        $('#calcBtn').
            attr({'disabled': 'disabled'}).
            removeClass('fanexBtnOrange').
            addClass('fanexBtnOutlineOrange');
        $('#paymentBtn').
            removeAttr('disabled').
            addClass('fanexBtnOrange').
            removeClass('fanexBtnOutlineGrey');
        $('#fakeInput').focus();
        reloadCaptcha();

        document.onkeyup = function(event) {
            event.preventDefault();
            if (event.which == 13 || event.keyCode == 13) {
                $('#paymentBtn').click();
            }
        };

    });
}

function removeComma(amount) {
    return parseFloat(amount.replace(/,/g, ''));
}

function countdown(ttl) {
    if (!isNaN(ttl)) {
        var tenMins = new Date().getTime() + (ttl * 1000);
        $('#countdown').countdown(tenMins, function(event) {
            $(this).html(event.strftime('%M:%S'));
        }).on('finish.countdown', function() {
            $('#countdown').html(timeOut).addClass('shake animated');
        });
    }
    else {
        $('#countdown').html(timeOut).addClass('shake animated');
    }
}

function readCookie(name) {
    var nameEQ = name + '=';
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1, c.length);
        }
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
}

function reloadCaptcha() {
    $('#captcha').val('');
    var captcha = $('.captcha-img');
    var config = captcha.data('refresh-config');
    $.ajax({
        method: 'GET',
        url: '/get_captcha/' + config,
    }).done(function(response) {
        captcha.prop('src', response);
    });
}

/*
 | Change Language Modal
 */
var ModalEffects = (function() {
    function init() {
        var overlay = document.querySelector('.md-overlay');
        [].slice.call(document.querySelectorAll('.md-trigger')).
            forEach(function(el, i) {
                var modal = document.querySelector(
                        '#' + el.getAttribute('data-modal')),
                    close = modal.querySelector('.md-close');

                function removeModal(hasPerspective) {
                    classie.remove(modal, 'md-show');
                    if (hasPerspective) {
                        classie.remove(document.documentElement,
                            'md-perspective');
                    }
                }

                function removeModalHandler() {
                    removeModal(classie.has(el, 'md-setperspective'));
                }

                el.addEventListener('click', function(ev) {
                    classie.add(modal, 'md-show');
                    overlay.removeEventListener('click', removeModalHandler);
                    overlay.addEventListener('click', removeModalHandler);
                    if (classie.has(el, 'md-setperspective')) {
                        setTimeout(function() {
                            classie.add(document.documentElement,
                                'md-perspective');
                        }, 25);
                    }
                });
                close.addEventListener('click', function(ev) {
                    ev.stopPropagation();
                    removeModalHandler();
                });
            });
    }

    init();
})();

// PDF Generation

var form = $('#pdfWrapper'),
    cache_width = form.width(),
    cache_height = form.height(),
    a4 = [595.28, 990.89]; // for a4 size paper width and height

var canvasImage,
    winHeight = a4[1],
    formHeight = form.height(),
    formWidth = form.width();

var imagePieces = [];

// on create pdf button click
$('#print-pdf').on('click', function() {
    imagePieces = [];
    imagePieces.length = 0;
    window.scrollTo(0, 0);
    main();
});

// main code
function main() {
    getCanvas().then(function(canvas) {
        canvasImage = new Image();
        canvasImage.src = canvas.toDataURL('image/png');
        canvasImage.onload = splitImage;
    });
}

// create canvas object
function getCanvas() {
    form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
    form.addClass('pdf');

    return html2canvas(form, {
        onrendered: function(canvas) {
            theCanvas = canvas;
            form.removeClass('pdf');
        },
        imageTimeout: 2000,
        removeContainer: true,
        letterRendering: false,
        background: '#fff',
        logging: true,
    });
}

// chop image horizontally
function splitImage(e) {
    var totalImgs = Math.round(formHeight / winHeight);
    for (var i = 0; i < totalImgs; i++) {
        var canvas = document.createElement('canvas'),
            ctx = canvas.getContext('2d');
        canvas.width = formWidth;
        canvas.height = winHeight;
        canvas.background = '#fff';
        ctx.drawImage(canvasImage, 0, i * winHeight, formWidth, winHeight, 0, 0,
            canvas.width, canvas.height);

        imagePieces.push(canvas.toDataURL('image/png'));
    }
    console.log(imagePieces.length);
    createPDF();
}

// crete pdf using chopped images
function createPDF() {
    var totalPieces = imagePieces.length - 1;
    var doc = new jsPDF({
        unit: 'px',
        format: 'a4',
    });
    imagePieces.forEach(function(img) {
        doc.addImage(img, 'PNG', 0, 0);
        if (totalPieces) {
            doc.addPage();
        }
        totalPieces--;
    });
    doc.save('invoice.pdf');
    form.width(cache_width);
    form.height(cache_height);
}
