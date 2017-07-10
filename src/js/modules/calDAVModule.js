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

    jQuery.CalDAVModule = function (el, options) {
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



        };

        base.getRoomData = function(path){

        };


        //returns HTML content to display
        jQuery.getRoomContent = function getRoomContent(path){
            console.log("path: " + path);
            return '<div id="calendar"></div>';
        };

        //returns HTML content to display
        jQuery.initCalender = function initCalender(path){

            /** var ics_sources = [
                {
                    url: path,
                    event_properties: {
                        color: 'gold'
                    }
                }
            ]

            var sources_to_load_cnt = 0;


            function data_req(url, callback) {
                var req = new XMLHttpRequest()
                req.addEventListener('load', callback)
                req.open('GET', url)
                req.send()
            }

            function add_recur_events() {
                if (sources_to_load_cnt < 1) {
                    $('#calendar').fullCalendar('addEventSource', expand_recur_events)
                } else {
                    setTimeout(add_recur_events, 30)
                }
            }

            function load_ics(ics) {
                data_req(ics.url, function () {
                    $('#calendar').fullCalendar('addEventSource', fc_events(this.response, ics.event_properties))
                    sources_to_load_cnt -= 1
                })
            }

                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    defaultView: 'month',
                    defaultDate: '2016-03-01'
                })
                var sources_to_load_cnt = ics_sources.length
                for (var ics in ics_sources) {
                    load_ics(ics)
                }
                add_recur_events()
             **/


            $('#calendar').fullCalendar({
                defaultView: 'agenda',
                visibleRange: function(currentDate) {
                    return {
                        start: currentDate.clone().subtract(1, 'days'),
                        end: currentDate.clone().add(5, 'days') // exclusive end, so 5
                    };
                },
                header: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                nowIndicator: true,
                weekends:false,
                heightContent: "auto",
                height: "auto",
                minTime: "07:00:00",
                maxTime: "21:00:00",
                allDaySlot:false,
                editable: false,
                columnFormat:'ddd',
                displayEventTime: true,// Display event time
                events: function( start, end, timezone, callback ) {
                    var events =[
                        {
                            title  : 'Meeting with P002',
                            start  : '2017-07-10T08:00:00',
                            allday: false
                        },
                        {
                            title  : 'Review of current master project',
                            start  : '2017-07-11T12:00:00',
                            allday: false
                        },{
                            title  : 'Food with the Janosch',
                            start  : '2017-07-13T13:40:00',
                            allday: false
                        },
                        {
                            title  : 'Hanging out with the Janosch',
                            start  : '2017-07-13T17:00:00',
                            allday: false
                        },{
                            title  : 'Netflix',
                            start  : '2017-07-14T15:30:00',
                            allday: false
                        }];
                    events.push({
                        title: 'This is a Material Design event!',
                        start: '2015-11-20T08:30:00',
                        end: '2015-11-20T08:30:00',
                        color: '#C2185B'
                    })
                    callback(events);
                }
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