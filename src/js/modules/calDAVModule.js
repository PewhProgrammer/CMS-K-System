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

var ics_sources;
(function (jQuery) {
    "use strict";

    jQuery.CalDAVModule = function (el, options) {
        // To avoid scope issues, use 'base' instead of 'this'
        // to reference this class from internal events and functions.
        var base = this;

        /**
         * initialisation
         */
        base.init = function () {
            // merge given options with default options
            // merge given options with default options
            base.options = $.extend({
                path: 'empty'
            }, options || {});

            // Access to jQuery and DOM versions of element
            base.el = el;
            base.$el = jQuery(el);

            //console.log("CalDAVModule loaded");
            base.$el.html('<div id="calendar"></div>');
            base.getContent(base.options.path);
        };

        //returns HTML content to display
        base.getContent = function (path) {
            //console.log("path loaded: " + path);

            ics_sources = [{url:path}];
            $.getScript("../libs/icalendar2fullcalendar/wrapper.js", function(){
                console.log("Running wrapper.js");
            });

        };

        // call init method
        base.init();
    };

    jQuery.fn.CalDAVModule = function (options) {
        return this.each(function () {
            new jQuery.CalDAVModule(this, options);
        });
    };
})(jQuery);