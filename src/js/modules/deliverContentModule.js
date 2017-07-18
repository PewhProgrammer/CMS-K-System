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
            base.types = {};
            base.mID = getUrlVars()["mID"];
            base.interval = 10; //in seconds
            base.$content = base.$el.find(".content");

            console.log("deliverContentModule loaded");

            function postRequest(){

                if(base.mID !== null){
                    $.post("../php/ContentManager.php", {mID: base.mID})
                        .done(function (data) {
                            console.log(JSON.parse(data)['msg']);

                            if(JSON.parse(data)['code'] !== 200){
                                if(JSON.stringify(JSON.parse(data)['msg']) === '"No mID found"'){
                                    base.$content.html('<div class="bs-callout bs-callout-warning"> ' +
                                        '<h4 id="bs-header">This monitor ID is not registered in the system</h4> ' +
                                        '<p>You can register this monitor with its unique <code class="highlighter-rouge">mID</code> by clicking on the button below</p>' +
                                        '<div class="row">&nbsp;</div>' +
                                        '<button type="button" class="btn btn-default" data-dismiss="modal">add Monitor</button>'+
                                        '</div>');
                                }
                                return;
                            }

                            var tmp = JSON.stringify(base.types);
                            base.types = JSON.parse(JSON.parse(data)['msg']);
                            var newData = JSON.stringify(base.types);

                            if(tmp.localeCompare(newData) !== 0) { //update view only on changes
                                updateView();
                            }
                        })
                        .fail(function (data) {
                            base.$content.html(JSON.stringify(JSON.parse(data)));
                        });
                }else{
                    base.$content.html('<div class="bs-callout bs-callout-warning"> ' +
                        '<h4 id="bs-header">The system could not find the monitor ID</h4> ' +
                        '<p>Ensure that you have set up the URL parameters correctly: <code class="highlighter-rouge">?mID=</code>[Insert Monitor ID]</p>'+
                        '</div>');
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

                if(!(0 < base.types["pdf"]["no"] || 0 < base.types["website"]["no"] || 0 < base.types["image"]["no"] || 0 < base.types["rss"]["no"] ||
                    0 <  base.types["caldav"]["no"] || base.types["bus"] || base.types["mensa"])) {
                    base.$content.html("Go to the admin panel and attach a content to this monitor!");
                    base.$content.html('<div class="bs-callout bs-callout-warning"> ' +
                        '<h4 id="bs-header">This monitor does not yet have a content attached</h4> ' +
                        '<p>Go to the admin panel <code class="highlighter-rouge">/admin</code> and attach a content to this monitor!</p>'+
                        '</div>');
                    return;
                }
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