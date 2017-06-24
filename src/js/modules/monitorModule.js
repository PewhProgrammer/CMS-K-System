/**
 * Created by Marc on 14.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.monitorModule = function (el, options) {
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

            var monitors = 0;
            var selected = 0;
            var selectAllTrigger = true;

            base.$el.find(".monitor_overview").each(function () {
                monitors++;
                if ($(this).find("input").is(":checked")) {
                    $(this).css({"border-color": "#333333"});
                    selected++;
                }
            });

            for(var i=0; i < monitors; i++) {
                $("#monInput-"+i).change(function() {
                    if (this.checked) {
                        $(this).parent().css({"border-color": "#333333"});
                        selected++;
                    } else {
                        $(this).parent().css({"border-color": "transparent"});
                        selected--;
                    }

                    if (selected === 0) {
                        $("#previewPanel").fadeOut();
                        $("#monitorForm").delay(400).animate({width: "100%"});
                    } else if (selected === 1) {
                        $("#monitorForm").animate({width: "66%"});
                        $("#previewPanel").delay(400).fadeIn();
                        // add details for monitor preview here
                    } else {
                        // add details for multiple monitor preview here
                    }
                });
            }

            base.$el.find("a").click(function () {
                if($(this).find("i").hasClass("fa-angle-down")) {
                    $(this).find("i").removeClass("fa-angle-down").addClass("fa-angle-right");
                } else {
                    $(this).find("i").removeClass("fa-angle-right").addClass("fa-angle-down");
                }
            });

            $("#selectAll").on("click",function(){
                $(".monitor_overview input").each(function () {
                    //this.trigger('click');
                    $(this).trigger('click');
                    //console.log(this);
                });
                if(selectAllTrigger) $("#selectAllDescription").text(" Deselect All");
                else $("#selectAllDescription").text(" Select All");

                selectAllTrigger = !selectAllTrigger;
                console.log(selectAllTrigger);
            });

        };
        // call init method
        base.init();
    };

    jQuery.fn.monitorModule = function (options) {
        return this.each(function () {
            new jQuery.monitorModule(this, options);
        });
    };
})(jQuery);