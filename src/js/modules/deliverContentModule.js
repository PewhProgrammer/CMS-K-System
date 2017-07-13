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

    jQuery.deliverContentModule = function (el, options) {
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
            base.mID = getUrlVars()["mID"];
            base.types = {};
            base.interval = 10; //in seconds
            base.$content = base.$el.find(".content");

            console.log("deliverContentModule loaded");

            function postRequest(){

                if(base.mID !== undefined){
                    $.post("../php/ContentManager.php", {mID: base.mID})
                        .done(function (data) {
                            console.log(data);
                            var tmp = JSON.stringify(base.types);
                            base.types = JSON.parse(data);
                            var newData = JSON.stringify(base.types);

                            if(tmp.localeCompare(newData) !== 0) { //update view only on changes
                                updateView();
                            }

                        })
                        .fail(function () {
                            // failed
                        });
                }

            }


            function timedPoll(){
                postRequest();

                setTimeout(function(){
                    timedPoll();
                }, base.interval * 1000);
            }

            function updateView(){
                if(base.types["pdf"]["no"] === 1){
                    console.log("pdf");
                    $(".content").html('<iframe height="100%" width="100%" src="' + base.types["pdf"]["path"][0] + '" frameborder="0" scrolling="no" ></iframe>');
                }
                else if (base.types["website"]["no"] === 1){
                    console.log("website");
                    $(".content").html('<iframe height="100%" width="100%" src="' + base.types["website"]["path"][0] + '" frameborder="0" scrolling="no" ></iframe>');
                }
                else if (base.types["image"]["no"] === 1){
                    $(".content").html('<p><a class="slideshowElements"  href="'+ base.types["image"]["path"][0] +'" title="SlideshowItem">1</a></p>');
                    $(".slideshowElements").colorbox({rel:'slideshowElements', slideshow:true, open:true, closeButton: false, opacity: 1});
                }
                else if (base.types["bus"]["no"] === 1){
                    MensaBusModule().getBusData();
                }
                else if (base.types["mensa"] === 1){
                    MensaBusModule().getMensaData();
                }
                else if (base.types["rss"]["no"] === 1){
                    base.$content.rssModule({path: base.types["rss"]["path"]});
                }
                else if (base.types["caldav"]["no"] === 1){
                    base.$content.CalDAVModule({path: base.types["caldav"]["path"]});
                }
            }

            function getUrlVars()
            {
                var vars = [], hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for(var i = 0; i < hashes.length; i++)
                {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
            }

            timedPoll();

        };

        // call init method
        base.init();
    };

    jQuery.fn.deliverContentModule = function (options) {
        return this.each(function () {
            new jQuery.deliverContentModule(this, options);


        });
    };
})(jQuery);