$(document).ready(function () {
    $('.selectpicker').selectpicker({

    });

    $('#exCountry, #exCurrency').change(function () {
        $('.tempAmount').slideUp(300);
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

    //About Page Scroll Bar
    $('.fanexMotto, .dropdown-menu .inner, textarea').niceScroll({
        cursorcolor: "#000",
        cursoropacitymin: 0.1,
        cursoropacitymax: 0.4,
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: "5px"
    });
});

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
                reloadCaptcha();
                var json = $.parseJSON(xhr.responseText);
                $(json).each(function(i,val) {
                    $('#mainFormLoader .spinner2').fadeOut(200);
                    $.each(val, function (k, v) {
                        $('#mainFormLoader .errors').fadeIn(200).html(v);
                        setTimeout(function() {
                            $('#mainFormLoader, #mainFormLoader .errors').fadeOut(200);
                            $('#mainFormLoader .spinner2').fadeIn();
                        }, 1000);
                    });
                });
            }
        }).done(function (response) {
            $('#mainFormLoader').fadeOut(200);
            $('#tempAmountCash').text(accounting.formatMoney($('#exAmount').val(), "", 2) + ' ' + $('#exCurrency').val() + 's');
            $('#tempAmountCountry').text($('#exCountry').val());
            $('.calcAmount').text(accounting.formatMoney(response, "", 0));
            $('.tempAmount').slideDown(300);
            reloadCaptcha();
        });
    }, 1000);
}

// svg path for target icon
var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";

var map = AmCharts.makeChart("mapWrapper", {
    "type": "map",
    "theme": "black",
    "projection": "miller",
    "dataProvider": {
        "map": "worldHigh",
        "zoomLevel": 1,
        /* "lines": [
         Tehran - Ankara, Turkey
         {
         "latitudes": [35.6892, 39.9334],
         "longitudes": [51.3890, 32.8597]
         }
         ],
         "images": [{
         "id": "Tehran",
         "svgPath": targetSVG,
         "title": "Tehran",
         "latitude": 35.6892,
         "longitude": 51.3890,
         "scale": 0.5,
         "showAsSelected": true
         }, {
         "svgPath": targetSVG,
         "title": "Ankara",
         "latitude": 39.9334,
         "longitude": 32.8597,
         "scale": .5,
         "showAsSelected": true
         }, {
         "svgPath": targetSVG,
         "title": "Washington",
         "latitude": 38.9072,
         "longitude": -77.0369,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Brussels",
         "latitude": 50.8371,
         "longitude": 4.3676,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Athens",
         "latitude": 37.9792,
         "longitude": 23.7166,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Oslo",
         "latitude": 59.9138,
         "longitude": 10.7387,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Lisbon",
         "latitude": 38.7072,
         "longitude": -9.1355,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Moscow",
         "latitude": 55.7558,
         "longitude": 37.6176,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Madrid",
         "latitude": 40.4167,
         "longitude": -3.7033,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Stockholm",
         "latitude": 59.3328,
         "longitude": 18.0645,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Bern",
         "latitude": 46.9480,
         "longitude": 7.4481,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Paris",
         "latitude": 48.8567,
         "longitude": 2.3510,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Rome",
         "latitude": 41.9028,
         "longitude": 12.4964,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Berlin",
         "latitude": 52.5200,
         "longitude": 13.4050,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Vienna",
         "latitude": 48.2082,
         "longitude": 16.3738,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Helsinki",
         "latitude": 60.1699,
         "longitude": 24.9384,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Copenhagen",
         "latitude": 55.676098,
         "longitude": 12.568337,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Amsterdam",
         "latitude": 52.3702,
         "longitude": 4.8952,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Baghdad",
         "latitude": 33.3128,
         "longitude": 44.3615,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Beijing",
         "latitude": 39.9042,
         "longitude": 116.4074,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Ottawa",
         "latitude": 45.4215,
         "longitude": -75.6972,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Yerevan",
         "latitude": 40.1792,
         "longitude": 44.4991,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Baku",
         "latitude": 40.4093,
         "longitude": 49.8671,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Riyadh",
         "latitude": 24.7136,
         "longitude": 46.6753,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Damascus",
         "latitude": 33.5138,
         "longitude": 36.2765,
         "scale": 0.5
         }, {
         "svgPath": targetSVG,
         "title": "Dubai",
         "latitude": 25.2048,
         "longitude": 55.2708,
         "scale": 0.5
         }],*/
        "areas": [{
            "title": "Iran (IR)",
            "id": "IR",
            "showAsSelected": true
        }, {
            "title": "Turkey (TR)",
            "id": "TR",
            "showAsSelected": true
        }, {
            "title": "United States of America (USA)",
            "id": "US",
            "showAsSelected": true
        }, {
            "title": "United Arab Emirates (UAE)",
            "id": "AE",
            "showAsSelected": true
        }, {
            "title": "Japan (JP)",
            "id": "JP",
            "showAsSelected": true
        }],
    },

    "balloon": {
        "color": "#000000",
        "borderColor": "#000000",
        "fillColor": "#FFFFFF"
    },

    "areasSettings": {
        "unlistedAreasColor": "#000",
        "unlistedAreasAlpha": 0.08,
        "unlistedAreasOutlineAlpha": 0.02,
        "selectedColor": "#000",
        "rollOverColor": "#FFFFFF",
        "outlineAlpha": "0",
        "alpha": 0.2
    },

    "imagesSettings": {
        "color": "rgba(0, 0 ,0 ,0.5)",
        "rollOverColor": "#000",
        "selectedColor": "#fff"
    },

    "linesSettings": {
        "arc": -0.7,
        "arrow": "middle",
        "color": "#fff",
        "alpha": 0.8,
        "arrowAlpha": 0,
        "arrowSize": 0
    },
    "zoomControl": {
        "zoomControlEnabled": false,
        "homeButtonEnabled": false
    },
    "zoomOnDoubleClick": false,
    "dragMap": false,
    // "backgroundZoomsToTop": true,
    "linesAboveImages": true,
    "export": {
        "enabled": false
    }
});