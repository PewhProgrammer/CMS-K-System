/**
 * Created by Thinh-Laptop on 01.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.globalModule = function (el, options) {
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

            jQuery.getParameterByName = function getParameterByName(name, url) {
                if (!url) url = window.location.href;

                name = name.replace(/[\[\]]/g, "\\$&");
                var results = url.split(name+"=");
                results.splice(0, 1);
                for (var i = 0; i < results.length; i++)
                    results[i] = results[i].replace(/[^a-zA-Z0-9.]/g, "");
                if (!results) return null;
                return results;
            };

            jQuery.getParameters = function getParameters() {
                var url = window.location.href;
                return url.split("?")[1];
            }
        };

        // call init method
        base.init();
    };

    jQuery.fn.globalModule = function (options) {
        return this.each(function () {
            new jQuery.globalModule(this, options);
        });
    };
})(jQuery);


