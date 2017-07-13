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

    jQuery.rssModule = function (el, options) {
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

            console.log("RSSModule loaded");
            base.$el.html('<div id="rss-feeds"></div>');
            base.getContent(base.options.path);

        };

        base.getContent = function(path){
            $("#rss-feeds").rss(
                path,
                {
                    // how many entries do you want?
                    // default: 4
                    // valid values: any integer
                    limit: 10,

                    // want to offset results being displayed?
                    // default: false
                    // valid values: any integer
                    offsetStart: false, // offset start point
                    offsetEnd: false, // offset end point

                    // will request the API via https
                    // default: false
                    // valid values: false, true
                    ssl: true,

                    // which server should be requested for feed parsing
                    // the server implementation is here: https://github.com/sdepold/feedr
                    // default: feedrapp.info
                    // valid values: any string
                    host: 'feedrapp.info',

                    // outer template for the html transformation
                    // default: "<ul>{entries}</ul>"
                    // valid values: any string
                    layoutTemplate: "<div class='feed-container'>{entries}</div>",

                    // inner template for each entry
                    // default: '<li><a href="{url}">[{author}@{date}] {title}</a><br/>{shortBodyPlain}</li>'
                    // valid values: any string
                    entryTemplate: '<div class="media"> <div class="media-left media-middle"> <a href="{url}"> <img class="media-object" src="{teaserImageUrl}" alt="RSSImage"> </a> </div> <div class="media-body"> <h4 class="media-heading">{title}</h4>{body}</div> </div>',

                    // additional token definition for in-template-usage
                    // default: {}
                    // valid values: any object/hash
                    tokens: {
                        foo: 'bar',
                        bar: function(entry, tokens) { return tokens.date }
                    },

                    // formats the date with moment.js (optional)
                    // default: 'dddd MMM Do'
                    // valid values: see http://momentjs.com/docs/#/displaying/
                    dateFormat: 'MMMM Do, YYYY',

                    // localizes the date with moment.js (optional)
                    // default: 'en'
                    dateLocale: 'de',

                    // formats the date in whatever manner you choose. (optional)
                    // this function should return your formatted date.
                    // this is useful if you want to format dates without moment.js.
                    // if you don't use moment.js and don't define a dateFormatFunction, the dates will
                    // not be formatted; they will appear exactly as the RSS feed gives them to you.
                    dateFormatFunction: function(date){},

                    // the effect, which is used to let the entries appear
                    // default: 'show'
                    // valid values: 'show', 'slide', 'slideFast', 'slideSynced', 'slideFastSynced'
                    effect: 'show',

                    // a callback, which gets triggered when an error occurs
                    // default: function() { throw new Error("jQuery RSS: url don't link to RSS-Feed") }
                    //error: function(){},

                    // a callback, which gets triggered when everything was loaded successfully
                    // this is an alternative to the next parameter (callback function)
                    // default: function(){}
                    success: function(){},

                    // a callback, which gets triggered once data was received but before the rendering.
                    // this can be useful when you need to remove a spinner or something similar
                    onData: function(){}
                },

                // callback function
                // called after feeds are successfully loaded and after animations are done
                function callback() {}
            )
        };

        // call init method
        base.init();
    };

    jQuery.fn.rssModule = function (options) {
        return this.each(function () {
            new jQuery.rssModule(this, options);


        });
    };
})(jQuery);