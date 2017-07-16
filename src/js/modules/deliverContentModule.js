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
                            //console.log(data);
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
                base.$content.html("");
                for (var i = 0; i < base.types["pdf"]["no"]; i++){
                    console.log("pdf");
                    base.$content.append('<iframe height="100%" width="100%" src="' + base.types["pdf"]["path"][i] + '" frameborder="0" scrolling="no" ></iframe>');
                }

                for (var j = 0; j < base.types["website"]["no"]; j++){
                    console.log("website");
                    base.$content.append('<iframe height="100%" width="100%" src="' + base.types["website"]["path"][j] + '" frameborder="0" scrolling="no" ></iframe>');
                }

                for (var k = 0; k < base.types["image"]["no"]; k++){
                    console.log("images");
                    base.$content.append('<p><a class="slideshowElements"  href="'+ base.types["image"]["path"][k] +'" title="SlideshowItem">item</a></p>');

                    if( k === base.types["image"]["no"]-1){
                        $(".slideshowElements").colorbox({rel:'slideshowElements', slideshow:true, open:true, closeButton: false, opacity: 1});
                    }

                }

                for (var l = 0; l < base.types["rss"]["no"]; l++){
                    console.log("rss");
                    base.$content.rssModule({path: base.types["rss"]["path"]});
                }
                for (var m = 0; m < base.types["caldav"]["no"]; m++){
                    console.log("caldav");
                    base.$content.CalDAVModule({path: base.types["caldav"]["path"]});
                }

                if (base.types["bus"]){
                    MensaBusModule().getBusData();
                }
                if (base.types["mensa"]){
                    MensaBusModule().getMensaData();
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