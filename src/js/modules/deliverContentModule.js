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
            base.contentArr = [];
            base.tOut = {};
            base.colorboxOptions = {rel:'slideshowElements', slideshowSpeed: base.interval * 1000, slideshow:true, open:true, closeButton: false, opacity: 1, height: '100%'};

            console.log("deliverContentModule loaded");

            function postRequest(){

                console.log('baseID: ' +base.mID);
                if(base.mID !== undefined){
                    $.post("../php/ContentManager.php", {mID: base.mID})
                        .done(function (data) {
                            //console.log(JSON.parse(data)['msg']);

                            if(JSON.parse(data)['code'] !== 200){
                                if(JSON.stringify(JSON.parse(data)['msg']) === '"No mID found"'){
                                    base.$content.html('<div class="bs-callout bs-callout-warning"> ' +
                                        '<h4 id="bs-header">The monitor ID '+base.mID+' is not registered in the system</h4> ' +
                                        '<p>You can register this monitor with its unique <code class="highlighter-rouge">mID = '+base.mID+'</code> by clicking on the button below</p>' +
                                        '<div class="row">&nbsp;</div>' +
                                        '<button id="addMonitor" type="button" class="btn btn-default" data-dismiss="modal">add Monitor</button>'+
                                        '</div>');
                                    $("#addMonitor").on('click',function(){
                                        var url = "../php/NewMonitor.php";
                                        $.post(url, {mID: base.mID})
                                            .done(function (data) {
                                                console.log(data);
                                                location.reload();
                                                //window.location.replace('index.php?attach=success');
                                            })
                                            .fail(function (data) {
                                                console.log('it failed');
                                                console.log(data);
                                                // failed
                                            });
                                    });
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
                        '<p>Ensure that you have set up the URL parameters correctly: <code class="highlighter-rouge">/?mID=</code>[Insert Monitor ID]</p>'+
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
                base.contentArr = [];

                if(!(0 < base.types["pdf"]["no"] || 0 < base.types["website"]["no"] || 0 < base.types["image"]["no"] || 0 < base.types["rss"]["no"] ||
                    0 <  base.types["caldav"]["no"] || base.types["bus"] || base.types["mensa"])) {
                    base.$content.html("Go to the admin panel and attach a content to this monitor!");
                    base.$content.html('<div class="bs-callout bs-callout-warning"> ' +
                        '<h4 id="bs-header">This monitor does not yet have a content attached</h4> ' +
                        '<p>Go to the admin panel <code class="highlighter-rouge">/admin</code> and attach a content to this monitor!</p>'+
                        '</div>');
                    return;
                }

                //append PDF as iFrame to the page
                for (var i = 0; i < base.types["pdf"]["no"]; i++){
                    console.log("pdf");
                    var $pdf_iframe = getIFrameObj(base.types["pdf"]["path"][i]);
                    appendContent($pdf_iframe);
                }

                //append websites as iFrame to the page
                for (var j = 0; j < base.types["website"]["no"]; j++){
                    console.log("website");
                    var $website_iframe = getIFrameObj(base.types["website"]["path"][j]);
                    appendContent($website_iframe);
                }

                //append images as slideshow to the page
                for (var k = 0; k < base.types["image"]["no"]; k++){
                    console.log("images");
                    if (k === 0){ //exec code only once at the first iteration
                        var $slideshow = $('<div id="slideshow"></div>');
                    }

                    $slideshow.append('<a class="slideshowElements"  href="'+ base.types["image"]["path"][k] +'" title="SlideshowItem">item</a>');

                    if (k === base.types["image"]["no"]-1){ //exec code only once at the last iteration
                        appendContent($slideshow);
                        $slideshow.children().colorbox(base.colorboxOptions);
                    }

                }
                console.log(base.contentArr);

                for (var l = 0; l < base.types["rss"]["no"]; l++){
                    console.log("rss");
                    var $rss = $('<div id="rss-feeds"></div>');
                    appendContent($rss);
                    //init rss
                    base.$content.rssModule({path: base.types["rss"]["path"]});
                }
                for (var m = 0; m < base.types["caldav"]["no"]; m++){
                    console.log("caldav");
                    var $calDav = $('<div id="calendar"></div>');
                    appendContent($calDav);
                    //init calDav
                    base.$content.CalDAVModule({path: base.types["caldav"]["path"]});
                }

                if (base.types["bus"]){
                    var $bus = $('<div id="mensa_panel"></div>');
                    appendContent($bus);
                    //init bus
                    base.$content.MensaBusModule("bus");
                }
                if (base.types["mensa"]){
                    var $mensa = $('<div id="bus_panel"></div>');
                    appendContent($mensa);
                    //init mensa
                    base.$content.MensaBusModule("mensa");
                }

                //switching between multiple content
                if (base.contentArr.length > 1) {
                    clearTimeout(base.tOut); //stop previous timeout
                    switching(base.contentArr, 0);
                }
                else { //only single content
                    base.contentArr[0].show();
                }


            }

            function getIFrameObj(path){
                return $('<iframe height="100%" width="100%" src="' + path + '" frameborder="0" scrolling="no" >Your browser does not support IFrame.</iframe>');
            }

            function appendContent($obj){
                $obj.hide();
                base.contentArr.push($obj);
                base.$content.append($obj);
            }

            function switching(arr, pos){
                console.log("switching over following content:" + arr + pos);

                var $prev = null,
                    $next = null,
                    interval = base.interval;

                if (pos === 0){
                   $prev = arr[arr.length-1];
                }
                else {
                   $prev = arr[pos-1];
                }
                $next = arr[pos];

                if (isSlideshow($prev)){
                    $.colorbox.close();
                }
                $prev.hide();

                if (isSlideshow($next)){
                    $next.children().colorbox(base.colorboxOptions);
                    interval = base.types["image"]["no"] * base.interval;
                }
                $next.fadeIn();


               base.tOut = setTimeout(function(){
                    var newPos = (arr.length-1 > pos)? ++pos : 0; //limit positions to array
                    switching(arr, newPos);
                }, interval * 1000);
            }

            function isSlideshow(obj){
                return (obj.is("#slideshow"));
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