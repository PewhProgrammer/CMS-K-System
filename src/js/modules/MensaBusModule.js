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

    jQuery.MensaBusModule = function (el, options) {
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

        base.getMensaData = function(){
            $.ajax({
                dataType: "json",
                url: "../php/mensa.php",
                data: "",
                success: function(data) {
                    console.log("Received mensa data");
                    render_mensa(data);
                }
            });
        };

        base.getBusData = function(){
            $.ajax({
                dataType: "json",
                url: "../php/bus.php",
                data: "",
                success: function(data) {
                    console.log("Received bus data");
                    render_bus(data);
                }
            });
        };

        function render_bus(bus_data) {
            var max_busses = 12;
            $("#bus_panel").append($("<div>Current departure times at <i>Stuhlsatzenhaus</i></div>"));
            var dom_busses = $("<div class='busses'>")
            $.each(bus_data.busses, function(i, bus) {
                if (i < max_busses) {
                    var dom_bus_timing = $("<div class='bus-timing'>");
                    var time = new Date(bus.time);
                    dom_bus_timing.append($("<div class='bus-time'>" + moment(bus.time).format("HH:mm") + "</div>"));
                    if (bus.delay != 0) {
                        dom_bus_timing.append($("<div class='bus-delay'>+" + bus.delay + " min</div>"));
                    }

                    if (bus.station == "A") {
                        var direction = " - Richtung Scheidt/Dudweiler";
                    }
                    else {
                        var direction = " - Richtung Universit&auml;t";
                    }
                    var dom_bus_route = $("<div class='bus-route'>");
                    dom_bus_route.append($("<div class='bus-line'>" + bus.line + direction + "</div>"));
                    dom_bus_route.append($("<div class='bus-destination'>" + bus.destination + "</div>"));

                    var dom_bus = $("<div class='bus'>");
                    dom_bus.append(dom_bus_timing);
                    dom_bus.append(dom_bus_route);
                    dom_busses.append(dom_bus);
                }
            });
            $("#bus_panel").html(dom_busses)
        }

        function render_mensa(mensa_data) {
            var dom_counters = $("<div>");
            $.each(mensa_data.counters, function(_, counter) {
               var dom_counter = $("<div class='counter'>");
                //dom_counter.append($("<div class='counter-bar' style='background-color: rgb(" + counter.color.r + ", " + counter.color.r + ", " + counter.color.r + ")'>"));

                var dom_counter_content = $("<div class='counter-content'></div>");
                dom_counter_content.append($("<div class='counter-header' style='background-color: rgba(" + counter.color.r + ", " + counter.color.g + ", " + counter.color.b + ", 0.8)'><span class='counter-title'>" + counter.displayName + "</span><span class='counter-description'>" + counter.description + "</div>"));
                $.each(counter.meals, function(_, meal) {
                    var dom_meal = $("<div class='meal'>");

                    /*
                     dom_pricing = $("<div class='pricing'></div>");
                     dom_pricing_table = $("<table class='pricing-table'>");
                     $.each(meal.prices, function(price_key, price_value) {
                     dom_pricing_table.append($("<tr><td><span class='pricing-key'>" + price_key + "</span></td><td><span class='pricing-value'>" + price_value + " &euro;</span></td></tr>"));
                     });
                     dom_pricing.append(dom_pricing_table);
                     dom_meal.append(dom_pricing);
                     */

                    var dom_meal_title = $("<div>");
                    if (meal.category != null) {
                        dom_meal_title.append($("<span class='meal-category'>" + meal.category + ":</span>"));
                    }
                    dom_meal_title.append($("<span class='meal-title'>" + meal.name + "</span>"));
                    dom_meal.append(dom_meal_title);

                    $.each(meal.components, function(_, component) {
                        dom_meal.append($("<div class='component'>" + component.name + "</div>"));
                    });

                    dom_counter_content.append(dom_meal);
                });

                dom_counter.append(dom_counter_content);
                dom_counters.append(dom_counter);
            });

            $("#mensa_panel").html(dom_counters)
        }
        // call init method
        base.init();
    };

    jQuery.fn.MensaBusModule = function (options) {
        return this.each(function () {
            new jQuery.MensaBusModule(this, options);


        });
    };
})(jQuery);