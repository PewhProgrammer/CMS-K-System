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

    jQuery.pdfModule = function (el, options) {
        // To avoid scope issues, use 'base' instead of 'this'
        // to reference this class from internal events and functions.
        var base = this;

        /**
         * initialisation
         */
        base.init = function () {
            // merge given options with default options
            base.options = $.extend({
                path: 'empty'
            }, options || {});

            // Access to jQuery and DOM versions of element
            base.el = el;
            base.$el = jQuery(el);
            base.interval = 300 * 1000; //check for updates every 5 minutes

            console.log("PDFModule loaded");
            base.getContent(base.options.path);


        };

        base.getContent = function(path){
            // Disable workers to avoid yet another cross-origin issue (workers need
            // the URL of the script to be loaded, and dynamically loading a cross-origin
            // script does not work).
            PDFJS.disableWorker = true;

            // Asynchronous download of PDF
            var loadingTask = PDFJS.getDocument(path);
            loadingTask.promise.then(function(pdf) {
                console.log('PDF loaded');

                var pdfDoc = null,
                    pageNum = 1,
                    scale = 0.8,
                    canvas = document.getElementById('pdf'),
                    ctx = canvas.getContext('2d');

                pdf.getPage(pageNum).then(function(page) {
                    console.log('Page loaded');
                    canvas.height = window.innerHeight;


                    var viewport = page.getViewport(canvas.height / page.getViewport(1.0).height);
                    canvas.width = viewport.width;

                    // Render PDF page into canvas context
                    var renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    var renderTask = page.render(renderContext);
                    renderTask.then(function () {
                        console.log('Page rendered');
                    });
                });
            }, function (reason) {
                // PDF loading error
                console.error(reason);
            });

        };

        // call init method
        base.init();
    };

    jQuery.fn.pdfModule = function (options) {
        return this.each(function () {
            new jQuery.pdfModule(this, options);


        });
    };
})(jQuery);