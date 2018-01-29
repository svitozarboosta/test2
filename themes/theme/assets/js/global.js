// Main Scripts
$(document).ready(function() {

    //document.ondragstart = noselect;
    // document.onselectstart = noselect;
    //document.oncontextmenu = noselect;

    $(document)
        .mouseup(function(e) {
            if ($(window).width() <= 600) {
                var container = $('header').find('.menu');
                if (container.has(e.target).length === 0) {
                    container.fadeOut(200);
                }
            }
        })
        .bind('copy cut', function() {
            if (userData.isSingle === '1' && userData.userAccont !== '1') {
                noselect();
                return false;
            }
        });


    /**
     * select logic
     */
    $('.email__select').click(function() {
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active')
        }
    });

    $(document).click(function(e) {
        var targ = $('.email__select');
        if (targ.has(e.target).length === 0) {
            targ.removeClass('active')
        }
    });


    /**
     * open login/signup logic
     */

    $('#login').click(function(e) {
        e.preventDefault();
        $('.shadow').fadeIn(200);
        $('#signup')
            .css({ display: 'flex' })
            .hide()
            .fadeIn(200);
        $('body').toggleClass('overflow');
    });


    if (location.pathname === '/account/levels/') {
        if (getCookie('loginTempModalLevel') !== false && getCookie('loginTempModalLevel') !== '') {
            cook = getCookie('loginTempModalLevel');
            setCookie('loginTempModalLevel', '', 30);
            window.location.href = "http://" + location.hostname + "/account/checkout/?level=" + cook;
        }
    }

    if (userData.userLogin !== '1' ) {
        $('.loginModal').click(function (e) {
            e.preventDefault();
            var attr = $(this).attr('data-level');

            if (typeof attr !== typeof undefined && attr !== false) {
                setCookie('loginTempModalLevel', $(this).attr('data-level'), 30);
                $('#login').click();
                $('#signup .signup__left').hide();
                $('#signup').css('width', 'auto');
            } else {
                setCookie('loginTempModalLevel', '', 30);
                $('#login').click();
                $('#signup .signup__left').hide();
                $('#signup').css('width', 'auto');
            }

        });

    } else {
        $('.loginModal').click(function (e) {
            e.preventDefault();
            setCookie('loginTempModalLevel', '', 30);
            window.location.href = $(this).attr('href');
        });
    }

    /**
     * Close All window if on shadow click
     */

    $('.shadow').click(function() {
        $('.shadow, #nocopy, #signup, #exit, #checker').fadeOut(200);
        $('body').removeClass('overflow');
    });


    $('.signup__close').click(function() {
        $('.shadow, #signup').fadeOut(200);
        $('body').removeClass('overflow');
    });

    $('#exit__trigger').hover(function() {
        ga('ec:addPromo', {
            'id': '1-exit',
            'name': 'exit-pop_up',
            'creative': 'exit_v1',
            'position': 'exit'
        });
        ga('send', 'event','pop-up', 'open', 'exit sample');
        $('.shadow, #exit').fadeIn(200);
    });

    $('.exit__close').click(function() {
        $('.shadow, #exit').fadeOut(200);
        $('body').removeClass('overflow');
    });

    $('.exit_btn').click(function() {
        $('.shadow, #nocopy').fadeOut(200);
        $('body').removeClass('overflow');
    });

    $('.exit_btn').click(function() {
        $('.shadow, #checker').fadeOut(200);
        $('body').removeClass('overflow');
    });

    $('.thanks').click(function() {
        $('.shadow, #nocopy, #checker').fadeOut(200);
        $('body').removeClass('overflow');
    });

    $('.burger').click(function() {
        $('header')
            .find('.menu')
            .css({ display: 'flex' })
            .hide()
            .fadeIn(200);
    });

    $('.signup__input')
        .children('input')
        .on('keydown', function() {
            console.log('keyown');
            if ($(this).val().length > 0) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });

    /**
     * Bottom Banner ON Scroll
     */
    function checkOffset() {
        if ($('.bottom-popup').length > 0) {
            if ($('.bottom-popup').offset().top + $('.bottom-popup').height() >= $('footer').offset().top - 10)
                $('.bottom-popup').css({
                    'position': 'absolute',
                    'top': '-85px'
                });
            if (window.matchMedia('(max-width: 745px)').matches) {
                $('.bottom-popup').css({
                    'position': 'absolute',
                    'top': '-95px'
                });
            }
            if ($(document).scrollTop() + window.innerHeight < $('footer').offset().top) {
                $('.bottom-popup').css({
                    'position': 'fixed',
                    'top': 'auto'
                });
            }
        }
    }

    $(document).scroll(function() {
        if ($('.bottom-popup').length > 0) {
            checkOffset();
        }
    });

    checkOffset();

    $('.bottom-popup__close').click(function() {
        $('.bottom-popup').fadeOut();
    });


    function noselect() {
        ga('ec:addPromo', {
            'id': '1-cp',
            'name': 'copy-past',
            'creative': 'copy-past_1',
            'position': 'all-page'
        });
        ga('send', 'event', 'pop-up', 'open', 'Copy-Past');
        ga('send', 'event', 'CTA', 'copy_past-edit_sample', 'open'); // TODO_S: Interesting Andrey Palyvoda by this GA
        if ($('.shadow').is(':hidden')) {
            $('.shadow').fadeIn(200);
            $('#nocopy')
                .css({ display: 'flex' })
                .hide()
                .fadeIn(200);
        }
    }

    (function() {
        if ($('.business__first-col').length) {
            $('.business__first-col').each(function(){
                if ($(this).html() !== "") {
                    $('.business__first-col').addClass('not-empty');
                    $('.business__flex-item').addClass('width-33');
                }
            });
        }
    })();

    if ($('#slider').length > 0) {
        $('#slider').slick({
            arrows: false,
            dots: true
        });
    }

});

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return false;
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function renderAlert(message, status) {
    var alertClass = {
        'info':     'alert-info',
        'success':  'alert-success',
        'error':    'alert-danger'
    };
    $('<div/>', {
        'class':    'alert ' + alertClass[status],
        'text':     message,
        'id':       'theme-alert'
    }).prepend(
        $('<strong/>', {
            'text': status + '! '
        })
    )
    .appendTo('footer');
    setTimeout(function() {
        $('#theme-alert').fadeOut(function() {
            this.remove();
        });
    }, 3500);
}

$(document).ready(function() {
    $(".set > a").on("click", function(e) {
        e.preventDefault();
        if ($(this).hasClass('active')) {
            $(this).removeClass("active");
            $(this).siblings('.content').slideUp(200);
        } else {
            $(".set > a").removeClass("active");
            $(this).addClass("active");
            $('.content').slideUp(200);
            $(this).siblings('.content').slideDown(200);
        }

    });

    $(window).scroll(function() {
        if ($(window).scrollTop() >= 0) {
            $('header').addClass('fixed-header');
        } else {
            $('header').removeClass('fixed-header');
        }
    });

    /* =====================
     Ajax function for forms
     ==================== */
    $('form[data-form="ajax"]').submit(function() {
        var form    = $(this);
        form.find(':input[type=submit]').attr('disabled', 'disabled');
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            success: function(response) {
                if(response.success) {
                    renderAlert(response.data, 'success');
                    // showAjaxMessage(form, response.data, true);
                    clearInputs(form);
                }
                else renderAlert(response.data, 'error');
                //showAjaxMessage(form, response.data, false);
            },
            error: function() {
                renderAlert(response.data, 'error');
                // showAjaxMessage(form, 'Try again.', false);
            }
        });
        return false;
    });

    // Function for show hidden response and remove him after few secons
    function showAjaxMessage(form, message, success) {
        if(success) form.append('<div class="alert alert-success hidden">' + message + '</div>').slideDown();
        else form.append('<div class="alert alert-danger hidden">' + message + '</div>').slideDown();
        setTimeout(function(){
            form.find('.alert').slideUp(function() {
                this.remove();
                form.find(':input[type="submit"]').removeAttr('disabled');
            });
        }, 5000);
    }

    // Clean inputs in form
    function clearInputs(form) {
        form.find('input, textarea').not(':input[type=button], :input[type=submit], :input[type=hidden], .noclean').each(function() {
            $(this).val('');
        });
    }

    // Register user form
    $('#register_user').submit(function(){
        var form = $(this);
        form.find('input[type="submit"]').prop("disabled", true);
        $.post('/wp-admin/admin-ajax.php', form.serialize(), function(data) {
            if (data.success) {
                ga('send', 'pageview', '/registration');
                window.location = data.data;
            } else {
                renderAlert(data, 'error');
                // form.find('#result').html(data).addClass('registered').slideDown();
                setTimeout(function() {
                    // form.find('#result').slideUp(function() {
                    //     form.find('#result').html('').removeClass('registered');
                    form.find('input[type="submit"]').removeAttr('disabled');
                    // })
                }, 3500);
            }
        });
        return false;
    });

    // Login user form
    $('#signup_form').submit(function(){
        var form = $(this);
        form.find('input[type="submit"]').prop("disabled", true);
        $.post('/wp-admin/admin-ajax.php', form.serialize(), function(data) {
            if (data.success) {
                ga('send', 'pageview', '/login');
                window.location.pathname = data.data;
            } else {
                renderAlert(data.data, 'error');
                // form.find('#login_result').html(data.data).addClass('logged').slideDown();
                setTimeout(function () {
                    // form.find('#login_result').slideUp(function () {
                    //     form.find('#login_result').html('').removeClass('logged');
                    form.find('input[type="submit"]').removeAttr('disabled');
                    // })
                }, 3500);
            }
        });
        return false;
    });

    // Submit nocopy form
    $('.nocopy__form').submit(function() {
        var form = $(this);
        form.find('input[type="submit"]').prop("disabled", true);
        $.post('/wp-admin/admin-ajax.php', form.serialize(), function(response) {
            if(response.success) {
                renderAlert(response.data, 'success');
                // showAjaxMessage(form, response.data, true);
                clearInputs(form);
            }
            else renderAlert(response.data, 'error');
            //showAjaxMessage(form, response.data, false);
        }, 'json');
        setTimeout(function () {
            form.find('input[type="submit"]').removeAttr('disabled');
        }, 3500);
        return false;
    });

    /***********************************
     **** Footer form for buy essay ****
     ***********************************/
    $('#footer_essay_form').submit(function() {
        var form = $(this),
        link = 'http://essays.businessays.net/fast-order?';
        link += 'foc_o_paper_type=' + form.find('select').val();
        link += '&foc_o_name=' + form.find('input[type=text]').val();
        link += '&foc_o_service=1';
        link += '&utm_source=businessays.net&utm_medium=R&utm_campaign=footer-form&utm_term=lets-us-create&utm_content=fast-order';
        if (form.find('input[type=text]').val() !== null) window.location.href = link;
        return false;
    });

    /**************
    **** Chat *****
    ***************/
    $('#chat .chat__close').click(function() {
       $('#chat').remove();
    });

    /***************
    **** Search ****
    ****************/
    if (!parseInt(userData.userLogin)) {
        $('.open_login_form').click(function (e) {
            e.preventDefault();
            $('.shadow').fadeIn(200);
            $('#signup')
                .css({display: 'flex'})
                .hide()
                .fadeIn(200);
            $('body').toggleClass('overflow');
        });
    }

    $('#nocopy_login').click(function () {
        $('#nocopy').hide();
        $('#signup')
            .css({display: 'flex'})
            .hide()
            .fadeIn(200);
    });

    /*************************************
     * Footer script (wtf inline script) *
     *************************************/
    (function() {
        // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
        if (!String.prototype.trim) {
            (function() {
                var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                String.prototype.trim = function() {
                    return this.replace(rtrim, '');
                };
            })();
        }

        [].slice.call(document.querySelectorAll('.input__field')).forEach(function(inputEl) {
            if (inputEl.value.trim() !== '') {
                classie.add(inputEl.parentNode, 'input--filled');
            }
            inputEl.addEventListener('focus', onInputFocus);
            inputEl.addEventListener('blur', onInputBlur);
        });

        function onInputFocus(ev) {
            classie.add(ev.target.parentNode, 'input--filled');
        }

        function onInputBlur(ev) {
            if (ev.target.value.trim() === '') {
                classie.remove(ev.target.parentNode, 'input--filled');
            }
        }
    })();

    /**************************
     * Blure button in single *
     **************************/
    // $('.single__content--toggle-blur').click(function(){
    //     var bluredBlock = $('.single__content--blur');
    //     bluredBlock.addClass('open');
    //     bluredBlock.find('.order').addClass('open');
    //     $(this).remove();
    // });


    /*
    Exit popup
     */
    if (userData.isMembership !== '1' && getCookie('exit_popup') !== '1' && $(window).width() > 768) {
        var lastYpos = 0;
        $(window).mousemove(function (event) {
            if (lastYpos > event.clientY && lastYpos < 5 && getCookie('exit_popup') !== '1' && userData.check !== '1') {
                $('.shadow').show();
                $('#exit').show();
                setCookie('exit_popup', 1, 1);
            }
            lastYpos = event.clientY;
        });
    }

    // if (userData.isMembership == '1' && getCookie('exit_popup_membership') !== '1' && $(window).width() > 768) {
    //     var lastYpos = 0;
    //     $(window).mousemove(function (event) {
    //         if (lastYpos > event.clientY && lastYpos < 5 && getCookie('exit_popup_membership') !== '1' && userData.check !== '1') {
    //             $('.shadow').show();
    //             $('#exit').show();
    //             setCookie('exit_popup_membership', 1, 1);
    //         }
    //         lastYpos = event.clientY;
    //     });
    // }

    // find end of animation css
    function whichAnimationEvent(){
        var t,
            el = document.createElement("fakeelement");

        var animations = {
            "animation"      : "animationend",
            "OAnimation"     : "oAnimationEnd",
            "MozAnimation"   : "animationend",
            "WebkitAnimation": "webkitAnimationEnd"
        }

        for (t in animations){
            if (el.style[t] !== undefined){
                return animations[t];
            }
        }
    }
    var animationEvent = whichAnimationEvent();

    // main
    var chat = $('#chat');
    chat.one(animationEvent, function(event) {
        ga('send', 'event', 'POP-UP', 'appear', '20sec_CheckItOut');
    });

    chat.find('.chat__close').click(function(){
        ga('send', 'event', 'POP-UP', 'close', '20sec_CheckItOut');
        chat.fadeOut();
    });

    /**
     * Analitics
     */
    $('.bottom-popup__plug').click(function() {
        ga('send', 'event', 'CTA', 'footer', 'get_custom_essay_sample');
    });
    // Exit popup
    $(document).on('click', '.js_cta_exit_popup_click_button', function () {
        ga('ec:addPromo', {
            'id': '1-exit',
            'name': 'exit-pop_up',
            'creative': 'exit_v1',
            'position': 'exit'
        });

        ga('ec:setAction', 'promo_click');
        ga('send', 'event', 'pop-up', 'click', 'exit sample');
    });
    $(document).on('click', '.exit__close', function() {
        ga('send', 'event','pop-up', 'close', 'exit sample');
    });
    // Nocopy popup
    $(document).on('.js_cta_nocopy_click_signup_button', 'click', function () {
        ga('ec:addPromo', {
            'id': '1-cp',
            'name': 'copy-past',
            'creative': 'copy-past_1',
            'position': 'all-page'
        });

        ga('ec:setAction', 'promo_click');
        ga('send', 'event', 'pop-up', 'click', 'Copy-Past');

    });
    $(document).on('click', '#nocopy input[type="submit"]', function() { // TODO_S: No input there
        ga('send', 'event', 'CTA', 'copy_past-edit_sample', 'click');
    });
    $('#chat').find('a').click(function(){
        ga('send', 'event', 'POP-UP', 'click', '20sec_CheckItOut');
    });
    $(document).on('click', '.exit__close', function() {
        ga('send', 'event','pop-up', 'close', 'exit sample');
    });
    $('.single_order_btn').click(function() {
        ga('send', 'event', 'CTA', 'content page', 'proceed');
    });

    $('#menu-footer-menu').superfish({
        //add options here if required
    });

    $('.footer-sf-menu > li.menu-item.menu-item-has-children > a').click(function (e) {
        e.preventDefault();
    });

    // Checker page
    $(document).on('click', '#checker .exit_btn', function () {
        ga("send", "event", "CTA", "copy_past-edit_sample", "close")
    });
    $(document).on('click', '#checker a.nocopy__form--btn', function () {
        ga("send", "event", "CTA", "copy_past-edit_sample", "singun")
    });
    $('.plagiarism_cta.original_text').click(function () {
        ga('send', 'event', 'CTA', 'checker', 'first');
    });
    $('.plagiarism_cta.free_content').click(function () {
        ga('send', 'event', 'CTA', 'checker', 'footer');
    });
});