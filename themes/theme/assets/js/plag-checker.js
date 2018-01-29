/**
 * Author: Nikolay Kovalenko
 * Date: 30.07.2017
 * Email: nikolay.arkadjevi4@gmail.com
 * */

var Business = {
    textearea: '#business-textToCheck',
    dropZone: '#business-upload',
    windows: window,
    submit_button_id: 'business-essayCheck',
    result_table: '#result-bottom .table-result-wrap table',
    preloader: '.business-dropzone .preload',
    existsFile: false,
    existsText: false,
    emptyFile: "Your file is empty!",
    emptyTextOrFile: "Please, insert text or add file!",
    pleaseEmptyText: "Please, empty textarea field",
    errorField: ".file-error",
    hasClicker: false,

    init: function () {
        this.uploadFile();
        this.dropzoneParams();
        this.getNewReport();
        this.checkText();
        this.uploadNewFile();
        this.userNoLogin();

        this.eppendClicker();
    },
    
    uploadFile: function () {
        $('#upload').click(function() {
            $(this).on('change', function() {
                var fileName = $(this)[0].files[0].name;
                $('#filename').text(fileName);
            })
        });
    },

    userNoLogin: function() {
        if (userData.userLogin !== '1' || userData.userAccont !== '1') {
            return false;
        }
    },

    eppendClicker: function () {
        var $this = this,
            checkerWrapper = $('.business');

        if ($this.userNoLogin() === false){
            $('<div class="checkerClicker"></div>').appendTo(checkerWrapper);
            $this.hasClicker = true;
        }

        if ($this.hasClicker === true) {
            checkerWrapper.find('.checkerClicker').click(function (e) {
                e.stopPropagation();
                e.preventDefault();
                $this.showRegistrationBanner();
            })
        }
    },

    showRegistrationBanner: function () {
        $('.shadow').fadeIn(200);
        $('#checker')
            .css({ display: 'flex' })
            .hide()
            .fadeIn(200);
        $('body').toggleClass('overflow');
        ga("send", "event", "CTA", "copy_past-edit_sample", "open");
    },

    getNewReport: function () {
        var $_this = this;
        $('.get-new-report').on('click', function (e) {
            e.preventDefault();
            var checkTextArea = $($_this.textearea);
            $('html,body').animate({
                scrollTop: $("#dropzone").offset().top - 100
            });

            if (checkTextArea.val() !== ""){
                checkTextArea.val('');
            }
            checkTextArea.focus();
        });
    },


  /*Cheker funcs */

    dropzoneParams: function () {
        var $_this = this;

        var dropzone = new Dropzone(this.dropZone, {
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            paramName: "file",
            maxFilesize: 5,
            maxFiles: 1,
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            acceptedFiles: ".doc,.docx,.pdf,.txt",
            accept: function(file, done) {
                console.log("uploaded");
                done();
            },
            thumbnail: function(file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function() { file.previewElement.classList.add("dz-image-preview"); }, 1);
                }
            },
            init: function() {
                this.on("maxfilesexceeded", function(file){
                    alert("No more files please!");
                });
                this.on("addedfile", function() {

                    if (this.files[1] != null){
                        this.removeFile(this.files[0]);
                    }
                    var fileName = this.files[0].name;
                    $('#filename').text(fileName);
                });
                
                this.on("sending", function () {
                    if ($_this.userNoLogin() === false) {
                        $_this.showRegistrationBanner();
                    }
                });

                this.on("dragend", function () {
                    if ($_this.userNoLogin() === false) {
                        $_this.showRegistrationBanner();
                    }
                });

                this.on("dragstart dragover", function () {
                    if ($_this.userNoLogin() === false) {
                        $_this.showRegistrationBanner();
                    }
                });

                this.on("success", function(file, response) {
                    if ($_this.userNoLogin() !== false) {
                        if (file.size > 0) {
                            $_this.existsFile = true;
                            if($_this.existsFile === true){
                                $_this.checkEssay(response);
                            }
                        } else {
                            $('html,body').animate({
                                scrollTop: $($_this.preloader).offset().top - 350
                            }, 700);
                            $($_this.errorField).text($_this.emptyFile).fadeIn(2000).fadeOut(3000);
                        }
                    }
                });
            }
        });
    },

    lightText: function(text, highlight) {
        var arrayText;
        arrayText = text.split(' ');
        $.each(highlight, function(index, el) {
            arrayText[el[0]-1] = '<b>' + arrayText[el[0]-1];
            if(el[1]-1 <= arrayText.length) {
                arrayText[el[1]-1] += '</b>';}
            else {
                arrayText[arrayText.length-1] += '</b>';
            }
        });

        arrayText = arrayText.join(' ');

        $('.business_result-data').html(arrayText);
    },

    checkEssay: function (response) {
        var $_this = this;
        $('#' + $_this.submit_button_id).click(function(){

            if ($_this.userNoLogin() === false) {
                $_this.showRegistrationBanner();
                return;
            }

            if($_this.existsFile === false){
                $('html,body').animate({
                    scrollTop: $($_this.preloader).offset().top - 350
                }, 700);
                $($_this.errorField).text($_this.emptyFile).fadeIn(2000).fadeOut(3000);
                return;
            }

            var textArea = $($_this.textearea);
            var textAreaVal = textArea.val();
            if (textAreaVal === "" && $_this.existsFile === true) {
                response = JSON.parse(response);
                $($_this.preloader).append('<div style="margin: 20px">Currently checking... <img src="/wp-content/uploads/2017/09/loader.gif" height="20px" width="20px"></div>');
                $_this.buildTable(response, response.matches);
                $('html,body').animate({
                    scrollTop: $("#dropzone").offset().top
                }, 700);
            } else {
                $($_this.errorField).text($_this.pleaseEmptyText).fadeIn(2000).fadeOut(3000);
            }
        });
    },

    checkText: function(){
        var $_this = this;

        $('#' + $_this.submit_button_id).click(function(){

            if ($_this.userNoLogin() === false) {
                $_this.showRegistrationBanner();
                return;
            }

            var url = '/wp-admin/admin-ajax.php';
            var textArea = $($_this.textearea);
            var textAreaVal = textArea.val();

            $('.file-error').text('').css('display', 'none');

            var textAreaLength = $.trim(textAreaVal).split(' ').filter(function(v){return v!==''}).length;

            if (textAreaVal !== "") {
                $_this.existsText = true;
            }



            if($_this.existsFile === false && $_this.existsText === false){
                $('html,body').animate({
                    scrollTop: $($_this.preloader).offset().top - 350
                }, 700);
                $($_this.errorField).text($_this.emptyTextOrFile).fadeIn(2000).fadeOut(3000);
                return;
            }

            if(textAreaLength < 100  && $_this.existsText === true){
                $('html,body').animate({
                    scrollTop: $($_this.preloader).offset().top - 350
                }, 700);
                $($_this.errorField).text('Your text is too short! Just ' + textAreaLength + ' words. Please enter at least 100 words. Thank you.').fadeIn(2000).fadeOut(3000);
                return;
            }

            if ($_this.existsText === true && $_this.existsFile !== true) {
                $('.business-fileform').css('visibility','hidden');

                var data = {
                    action: 'plagiarism_check',
                    text: textAreaVal
                };


                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    beforeSend: function () {
                        $('.file-error').text('').css('display', 'none');
                        $($_this.preloader).append('<div style="margin: 20px">Currently checking... <img src="/wp-content/uploads/2017/09/loader.gif" height="20px" width="20px"></div>');
                    },
                    success: function (response) {

                        if (response.success === 0) {
                            $('.file-error').css('display', 'none');
                            $($_this.errorField).text(response.error).fadeIn(1000).fadeOut(3000);
                            return;
                        }

                        response = JSON.parse(response);
                        $_this.buildTable(response, response.matches);
                        $('html,body').animate({
                            scrollTop: $("#dropzone").offset().top
                        }, 700);
                    },
                    error: function () {
                    }
                });

            }
        });
    },

    buildTable: function (response, responseM) {

        var $_this = this;

        var responseColor;

        $($_this.preloader).html('');

        $('.business-dropzone-helpfull').fadeOut();
        $('.dropzone.needsclick').fadeOut();
        $('#' + $_this.submit_button_id).fadeOut();

        var lenTextEl = $('.business_result-sub-data p .text-len');
        var lenTextElNoSpace =  $('.business_result-sub-data p .text-no-space');
        var unqPercEl =   $('.business_result-uniq .uniq-percent');

        var checkUniq = true;
        var lenText         = response.text.replace(/\s{2,}/igm, ' ').length;
        var lenWithoutSpace = response.text.replace(/\s/igm, '').length;
        var bottomBtns = $('#result-bottom .table-result-wrap + .business_result-btns');

        $('#result-bottom tbody').html('');
        $('.business_result-data').html('');

        lenTextEl.text();
        lenTextElNoSpace.text();
        unqPercEl.text();

        $_this.lightText(response.text, response.highlight);

        lenTextEl.text(lenText);
        lenTextElNoSpace.text(lenWithoutSpace);

        switch(true){
            case response.percent < 33:
                responseColor = '#F44336';
                break;
            case response.percent > 33 && response.percent < 66:
                responseColor = '#FFC107';
                break;
            case response.percent > 66:
                responseColor = '#4CAF50';
                break;
        }

        if (response.percent.toString() === "100.0".toString()) {
            checkUniq = false;
        }


        unqPercEl.text(response.percent + ' %').css('color', responseColor);

        if (checkUniq === true ) {
            var response2Color;
            $.each(responseM ,function(index, el) {
                switch(true){
                    case el.percent < 33:
                        response2Color = '#4CAF50';
                        break;
                    case el.percent > 33 && el.percent < 66:
                        response2Color = '#FFC107';
                        break;
                    case el.percent > 66:
                        response2Color = '#F44336';
                        break;
                }

                $('<tr/>').append(
                    $('<td/>', {
                        text: el.url
                    })
                ).append(
                    $('<td/>', {
                        style: 'color:' + response2Color,
                        text: el.percent
                    })
                ).append(
                    $('<td/>').append(
                        $('<a/>', {
                            href: '#dropzone',
                            text: 'Show',
                            class: 'business-show-uniq',
                            onclick: 'Business.lightText("'+ response.text + '",' +JSON.stringify(el.highlight)+ ')'
                        })
                    )
                ).appendTo('#result-bottom .table-result-wrap table tbody');

                $($_this.result_table).fadeIn();
                bottomBtns.fadeIn();
            });
        } else {
            $($_this.result_table).fadeOut();
            bottomBtns.fadeOut();
        }

        $('#result-top').fadeIn();
        $('.business_result-wrap').fadeIn();
        $('#result-bottom').fadeIn();
    },

    uploadNewFile: function () {
        var $_this = this;
        $('#upload').click(function() {
            $(this).on('change', function() {
                var fileName = $(this)[0].files[0].name;

                if ($(this)[0].files[0].size > 0) {
                    $_this.existsFile = true;

                    $($_this.preloader).html('');
                    $('#filename').text(fileName);
                    $('.business-fileform').css('visibility','visible');

                    var data = new FormData();
                    data.append('file', $(this)[0].files[0]);
                    $($_this.preloader).append('<div style="margin: 20px">Currently checking... <img src="/wp-content/uploads/2017/09/loader.gif" height="20px" width="20px"></div>');
                    jQuery.ajax({
                        url: '/wp-admin/admin-ajax.php?action=essay_checker_upload',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function(response){
                            response = JSON.parse(response);
                            $_this.buildTable(response, response.matches);
                            $('html,body').animate({
                                scrollTop: $("#dropzone").offset().top
                            }, 700);
                            $($_this.preloader).html('');
                        }
                    });
                } else {
                    $('html,body').animate({
                        scrollTop: $($_this.preloader).offset().top - 350
                    }, 700);
                    $($_this.errorField).text($_this.emptyFile).fadeIn(2000).fadeOut(3000);
                }
            })
        });
    }

};


jQuery(document).ready(
    function () {
        Business.init();
    }
);
