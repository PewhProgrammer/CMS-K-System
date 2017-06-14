/**
 * Created by Thinh-Laptop on 01.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.attachModule = function (el, options) {
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

            base.$el.css("background-color", "white");

            $("#ressourceList li input").change(function(){
                console.log("checked");
            });

            $("#something").change( function(){
                alert("state changed");
            });


        }



        // call init method
        base.init();
    };

    jQuery.fn.attachModule = function (options) {
        return this.each(function () {
            new jQuery.attachModule(this, options);
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

