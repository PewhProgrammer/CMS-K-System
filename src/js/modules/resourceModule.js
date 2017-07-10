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
                addRemoveLinks: true,
                init: function() {
                    var myDropzone = this;
                    base.$submitButton.on("click", function() {
                        myDropzone.processQueue();
                    });
                    myDropzone.on("complete", function(file) {
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

                if (fileType > 0){ //url
                    base.$urlForm.show();
                    base.$fileForm.hide();

                    if(fileType === 3) processCALDavHTML();
                    else{
                        $("#addResourceSubmit").prop('disabled',false);
                        base.$urlForm.html('<label for="url" id="urlHeader">Name:</label>' +
                            '<div class="input-group"> <div class="input-group-btn">'+
                            '<button type="button" value="0" id="dropdownMenuURL" class="btn btn-default dropdown-toggle" ' +
                            'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                            'http:// </button>'+
                            '<ul id="urlPrefixDrop" class="dropdown-menu">'+
                            '<li><a href="#">https:// </a></li></ul></div><!-- /btn-group -->'+
                            '<input type="text" class="form-control" id="url" aria-label="...">'+
                            '</div>' );

                        $("#urlPrefixDrop").find('li').click(function(){

                            /* Change DropDown Selection*/
                            var btnSelector = $("#dropdownMenuURL") ;
                            if(btnSelector.text().startsWith('https'))
                            btnSelector.val(0); // 0 = http | 1 = https
                            else btnSelector.val(1);
                            var help = '<a href="#">'+ btnSelector.text() + '</a>';
                            btnSelector.text($(this).text());
                            $(this).html(help);
                        });
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
                    .append('<div class="checkbox caldav"> <label><input id="caldavOpt0"  disabled type="checkbox"  value="">Access through API [Not implemented yet]</label> </div>')
                    .append('<div class="checkbox caldav"> <label><input id="caldavOpt1"  type="checkbox" value="">Access through local storage</label> </div>')
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
                        calDavDivSelector
                            .append('<input type="text" class="form-control" id="url">');
                    }
                    else{
                        base.$dropzoned = true;
                        base.$fileForm.show();
                    }
                    $("#addResourceSubmit").prop('disabled',false);
                });
            }


            base.$submitButton.on('click', function(event) {
                if(fileType < 0) {
                    base.$warning.find('p').text('Please choose a file type');
                    base.$warning.show();
                }

                var resourceResponse = $("#url").val();
                if(!base.$dropzoned){
                    if (resourceResponse.length < 1){
                        base.$warning.find('p').text('Please enter an URL');
                        base.$warning.show();
                    }
                    else {
                        //prepend http/s
                        console.log("value: " +$("#dropdownMenuURL").val());
                        if($("#dropdownMenuURL").val() === '0') resourceResponse = resourceResponse.replace(/^/,'http://');
                        else resourceResponse = resourceResponse.replace(/^/,'https://');
                        $.post('../php/add.php', {
                            name: resourceResponse,
                            type: (fileType === 1) ? 'website' : 'rss',
                            path: resourceResponse
                        }).done(function (data) {
                            base.$urlForm.hide();
                            base.$el.modal("hide");
                            base.$success.find("p").text('Entry successful');
                            base.$success.show();

                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }).fail(function () {

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
