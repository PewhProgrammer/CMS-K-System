/**
 *
 *
 * Class history:
 *  - 0.1: First release, working (jonasmohr)
 *
 * @author jonasmohr
 * @date 21.09.15
 * @constructor
 */

(function (jQuery) {
    "use strict";

    jQuery.exampleModule = function (el, options) {
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

        };

        // call init method
        base.init();
    };

    jQuery.fn.exampleModule = function (options) {
        return this.each(function () {
            new jQuery.exampleModule(this, options);


        });
    };
})(jQuery);