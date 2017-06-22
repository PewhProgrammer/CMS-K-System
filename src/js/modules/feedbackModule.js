/**
 * Created by Marc on 14.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.feedbackModule = function (el, options) {
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

            //language=JQuery-CSS
            var successAlertID = $("#success-alert");
            successAlertID.hide();
            $("#warning-alert").hide();

            var response = $.getParameterByName('attach');
            if (response[0] === 'success') {
                console.log('alert');
                successAlertID.alert();

                successAlertID.fadeTo(6000, 1000).slideUp(500, function () {
                    successAlertID.slideUp(500);
                });
            }
        };
        // call init method
        base.init();
    };

    jQuery.fn.feedbackModule = function (options) {
        return this.each(function () {
            new jQuery.feedbackModule(this, options);
        });
    };
})(jQuery);