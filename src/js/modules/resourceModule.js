/**
 * Created by Thinh-Laptop on 01.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.resourceModule = function (el, options) {
        // To avoid scope issues, use 'base' instead of 'this'
        // to reference this class from internal events and functions.
        var base = this;

        /**
         * initialisation
         */
        base.init = function () {
            // merge given options with default options
            jQuery.extend(base.options, options);

            // Access to jQuery and DOM versions of element
            base.el = el;
            base.$el = jQuery(el);
            base.$submitButton = $('#addResourceSubmit');
            base.$urlForm = $('#urlForm');
            base.$fileForm = $('#fileForm');
            base.$warning = $("#warning-alert-config");
            base.$success = $("#success-alert-config");

            base.$urlForm.hide();
            base.$fileForm.hide();

            base.$dropzoned = false;


            var fileType = -1 ; // 0 = pdf/image ; 1 = Website ; 2 = RSS Feed AND -1 = none

            Dropzone.options.droppy = {
                paramName: "userfile", // The name that will be used to transfer the file
                maxFilesize: 2, // MB
                autoProcessQueue: false,
                dictDefaultMessage: "Click or drag files on top of this field",
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.ics",
                addRemoveLinks: true,
                init: function() {
                    var myDropzone = this;
                    base.$submitButton.on("click", function() {
                        myDropzone.processQueue();
                    });
                    myDropzone.on("complete", function(file) {

                        if(!file['accepted']) return;
                        myDropzone.removeFile(file);
                        base.$fileForm.hide();

                        base.$el.modal("hide");

                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    });
                }
            };

            var urlHeaderText = ['Enter a website URL','Enter a RSS feed URL','How to access the CalDAV data?'];

            $("#fileTypeDrop").find('li').click(function(){
                base.$dropzoned = false; // is it type dropzone
                $("#warning").hide();
                fileType = $(this).index();

                /* Change DropDown Selection*/
                var btnSelector = $("#dropdownMenu1") ;
                btnSelector.text($(this).text());
                btnSelector.val($(this).text());
                btnSelector.append(' <span class="caret"></span> ');

                $("#newResModalHeader").text('Submit a new resource');

                $("#addResourceSubmit").prop('disabled',false);
                if (fileType > 0){ //url
                    base.$urlForm.show();
                    base.$fileForm.hide();

                    if(fileType === 3) processCALDavHTML();
                    else{
                        base.$urlForm.html(renderInputField());

                        initHttpListener();
                    }
                    $("#urlHeader").text(urlHeaderText[fileType-1]);
                }
                else { //file upload
                    base.$dropzoned = true;
                    base.$urlForm.hide();
                    base.$fileForm.show();
                }
            });


            function processCALDavHTML(){
                $("#addResourceSubmit").prop('disabled',true);
                base.$urlForm.html('');
                base.$urlForm
                    .append('<label for="url" id="urlHeader">Name:</label>')
                    .append('<div class="checkbox caldav"> <label><input id="caldavOpt0"  type="checkbox"  value="">Access through API [Web URL]</label> </div>')
                    .append('<div class="checkbox caldav"> <label><input id="caldavOpt1"  type="checkbox" value="">Access through local storage (.ics)</label> </div>')
                    .append('<div id="calDavDiv"> </div>');
                $(".checkbox.caldav").find("input").change(function () {
                    var calDavDivSelector = $("#calDavDiv");
                    calDavDivSelector.html('');
                    if(!this.checked){
                        base.$fileForm.hide();
                        $("#addResourceSubmit").prop('disabled',true);
                        return ;
                    }
                    if($(this).attr('id') === 'caldavOpt0'){
                        $('#caldavOpt1').prop('checked',false);
                        base.$dropzoned = false;
                        base.$fileForm.hide();
                        calDavDivSelector
                            .append(renderInputField());
                        initHttpListener();
                    }
                    else{
                        $('#caldavOpt0').prop('checked',false);
                        base.$dropzoned = true;
                        base.$fileForm.show();
                    }
                    $("#addResourceSubmit").prop('disabled',false);
                });
            }

            function renderInputField(){
                return '<label for="url" id="urlHeader">Name:</label>' +
                    '<div class="input-group"> <div class="input-group-btn">'+
                    '<button type="button" value="0" id="dropdownMenuURL" class="btn btn-default" ' +
                    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                    'http:// </button></div><!-- /btn-group -->'+
                    '<input type="text" class="form-control" id="url" aria-label="...">'+
                    '</div>'
            }


            function initHttpListener(){
                $("#dropdownMenuURL").click(function(e){

                    /* Change DropDown Selection*/
                    var btnSelector = $("#dropdownMenuURL") ;
                    if(btnSelector.text().startsWith('https')) {
                        btnSelector.val(0); // 0 = http | 1 = https
                        btnSelector.text('http://');
                    }
                    else {
                        btnSelector.val(1);
                        btnSelector.text('https://');
                    }
                });
            }


            base.$submitButton.on('click', function(event) {
                if(fileType < 0) {
                    base.$warning.find('p').text('Please choose a file type');
                    base.$warning.show();
                }

                var resourceResponse = $("#url").val();
                if(!base.$dropzoned){
                    console.log("skip");
                    if (resourceResponse.length < 1){
                        base.$warning.find('p').text('Please enter an URL');
                        base.$warning.show();
                    }
                    else {
                        //prepend http/s
                        console.log("value: " +$("#dropdownMenuURL").val());
                        if($("#dropdownMenuURL").val() === '0') resourceResponse = resourceResponse.replace(/^/,'http://');
                        else resourceResponse = resourceResponse.replace(/^/,'https://');
                        var fType = (fileType === 1) ? 'website' : 'rss';
                        if(fileType === 3) fType = 'caldav';
                        $.post('../php/Add.php', {
                            name: resourceResponse,
                            type: fType,
                            path: resourceResponse
                        }).done(function (data) {
                            console.log("request processed.");
                            base.$urlForm.hide();
                            base.$el.modal("hide");
                            var readTime = 1000;

                            data = JSON.parse(data);
                            var header = '';
                            if(data['msg'] !== null) header = data['msg'].toLowerCase();

                            if(header === 'sameorigin' || header === 'deny' || header === 'allow-from'){
                                base.$warning.find("p").text('IFrame might not be able to show the content of '+resourceResponse+' due to same origin constraint. The page will refresh itself now...');
                                base.$warning.show();
                                readTime = 5000;
                            }else{
                                base.$success.find("p").text('Entry successful. The page will refresh itself now...');
                                base.$success.show();
                            }

                            //console.log(data['msg']);

                            setTimeout(function(){
                                location.reload();
                            }, readTime);
                        }).fail(function () {
                            base.$warning.find("p").text('Entry failed');
                        });
                    }

                }

/*
                if(checkURL(resourceResponse)){
                    console.log("Response: " + resourceResponse);
                }
                */
                console.log("FileType: " + fileType);
            });
        };

        // call init method
        base.init();
    };

    jQuery.fn.resourceModule = function (options) {
        return this.each(function () {
            new jQuery.resourceModule(this, options);
        });
    };
})(jQuery);

/*
function checkURL(url){
    var request;
    if(window.XMLHttpRequest)
        request = new XMLHttpRequest();
    else
        request = new ActiveXObject("Microsoft.XMLHTTP");
    request.open('GET', 'http://www.mozilla.org', false);
    request.send(); // there will be a 'pause' here until the response to come.
// the object request will be actually modified
    if (request.status === 404) {
        alert("The page you are trying to reach is not available.");
    }
}
*/
