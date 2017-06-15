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


            var fileType = -1 ; // 0 = pdf ; 1 = Image ; 2 = Website ; 3 = RSS Feed AND -1 = none

            Dropzone.options.dropMy = {
                paramName: "userfile", // The name that will be used to transfer the file
                maxFilesize: 2, // MB
                autoProcessQueue: false,
                dictDefaultMessage: "Hier reinziehen"
            };

            $("#fileTypeDrop li").click(function(){
                $("#warning").hide();
                fileType = $(this).index();
                console.log("index : " + fileType);
                var btnSelector = $("#dropdownMenu1") ;
                btnSelector.text($(this).text());
                btnSelector.val($(this).text());
                btnSelector.append(' <span class="caret"></span> ');

                if(fileType > 1){
                    $("#urlForm").show();
                    $("#fileForm").hide();
                    var urlHeaderText = '';
                    if(fileType === 2){
                        urlHeaderText += 'Enter a website URL';
                    }else{
                        urlHeaderText += 'Enter a RSS feed URL';
                    }


                    $("#urlHeader").text(urlHeaderText);
                }
                else {
                    $("#urlForm").hide();
                    $("#fileForm").show();
                }
            });

            $('#addResourceSubmit').on('click', function(event) {
                if(fileType < 0) {
                    $("#warningInput").text('Please choose a file type');
                    $("#warning").show();
                }
                var resourceResponse = $("#url").val();
                if(fileType > 1 && resourceResponse.length < 1){
                    $("#warningInput").text('Please enter an URL');
                    $("#warning").show();
                }

                if(fileType < 2){
                    $("#warningInput").text('Not implemented yet');
                    $("#warning").show();
                }

                if(checkURL(resourceResponse)){
                    console.log("Response: " + resourceResponse);
                }
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

