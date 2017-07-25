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
            var warningAlertID = $("#warning-alert");
            successAlertID.hide();
            $("#warning-alert").hide();

            var response = $.getParameterByName('attach');
            if (response[0] === 'success') {
                //console.log('alert');
                successAlertID.alert();
                $("#alertSuccessText").text('The system has updated the resource(s) of the monitor(s)');

                successAlertID.fadeTo(6000, 1000).slideUp(500, function () {
                    successAlertID.slideUp(500);
                });
            }else if(response[0] === 'failure'){
                warningAlertID.alert();
                $("#alertWarningText").text('The system could not update the content of the monitors');

                warningAlertID.fadeTo(6000, 1000).slideUp(500, function () {
                    warningAlertID.slideUp(500);
                });
            }

            response = $.getParameterByName('newMonitor');
            if (response[0] === 'success') {
                //console.log('alert');
                successAlertID.alert();
                $("#alertSuccessText").text('The system has successfully registered the new monitor');

                successAlertID.fadeTo(6000, 1000).slideUp(500, function () {
                    successAlertID.slideUp(500);
                });
            }else if(response[0] === 'failure'){
                warningAlertID.alert();
                $("#alertWarningText").text('The system could not register the new monitor');

                warningAlertID.fadeTo(6000, 1000).slideUp(500, function () {
                    warningAlertID.slideUp(500);
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