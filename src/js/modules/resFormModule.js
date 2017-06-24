/**
 * Created by Marc on 19.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.resFormModule = function (el, options) {
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

            /*
            base.$el.find(".k-selectable").each(function () {
                if ($(this).find("input").is(":checked"))
                    $(this).css({"border-color": "#333333"});
            });
*/
            base.$el.find(".k-selectable").click(function () {
                if ($(this).find("input").is(":checked")) {
                    $(this).css({"border-color": "#333333"});
                } else {
                    $(this).css({"border-color": "transparent"});
                }
            });


            base.$el.find(".fa-trash-o").click(function() {
                console.log("deleting: " + $(this).data("id"));

                $.post('../php/delete.php', {
                    id: $(this).data("id")
                }).done(function (data) {
                    $("#successInput").text('Deleted');
                    $("#success").show();
                }).fail(function () {

                });

            });

        };
        // call init method
        base.init();
    };

    jQuery.fn.resFormModule = function (options) {
        return this.each(function () {
            new jQuery.resFormModule(this, options);
        });
    };
})(jQuery)
