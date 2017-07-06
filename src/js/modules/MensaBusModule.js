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

    jQuery.MensaBusModule = function (el, options) {
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



        };

        base.getMensaData = function(){

        };

        base.getBusData = function(){

        };
        // call init method
        base.init();
    };

    jQuery.fn.MensaBusModule = function (options) {
        return this.each(function () {
            new jQuery.MensaBusModule(this, options);


        });
    };
})(jQuery);