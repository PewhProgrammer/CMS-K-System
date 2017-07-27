/**
 * Created by Thinh-Laptop on 01.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.previewModule = function (el, options) {
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
            base.$previewFrame = $("iframe#previewFrame");
            base.$noPreviewFrame = $("#noPreview");

            $("#resourceTable").find("input").change(function () {
                if (this.checked) {
                    var resType = $(this).attr("data-resType");
                    var resData = $(this).attr("data-resData");
                    //console.log(resType);

                    if(resType === 'pdf' || resType === 'image' || resType === 'rss' || resType === 'website'){
                        base.$noPreviewFrame.hide();
                        base.$previewFrame.show();
                        base.$previewFrame.attr("src", resData);
                    }
                    else{
                        base.$previewFrame.hide();
                        base.$noPreviewFrame.show();
                    }

                $("#previewResource").text($(this).val());
                }
            });


        };


        // call init method
        base.init();
    };

    jQuery.fn.previewModule = function (options) {
        return this.each(function () {
            new jQuery.previewModule(this, options);
        });
    };
})(jQuery);


