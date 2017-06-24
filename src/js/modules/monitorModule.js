/**
 * Created by Marc on 14.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.monitorModule = function (el, options) {
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

            var monitors = 0;
            var selected = 0;
            var deselectTrigger = false;
            var selectTrigger = false;

            base.$el.find(".monitor_overview").each(function () {
                monitors++;
                if ($(this).find("input").is(":checked")) {
                    $(this).css({"border-color": "#333333"});
                    selected++;
                }
            });

            for(var i=2; i <= (monitors+1); i++) {
                $("#monInput-"+i).change(function() {
                    if (this.checked) {
                        $(this).parent().css({"border-color": "#333333"});
                        selected++;
                        console.log
                        if(monitors === selected && !selectTrigger) $("#selectAllDescription").text(" Deselect All");
                        else $("#selectAllDescription").text(" Select All");
                    } else {
                        $(this).parent().css({"border-color": "transparent"});
                        selected--;
                        if(!deselectTrigger)
                        $("#selectAllDescription").text(" Select All");
                    }

                    //console.log("checked: " + selected + " monitors: " +monitors);

                    if (selected === 0) {
                        $("#previewPanel").fadeOut();
                        $("#monitorForm").delay(400).animate({width: "100%"});
                    } else if (selected === 1) {
                        $("#monitorForm").animate({width: "66%"});
                        $("#previewPanel").delay(400).fadeIn();
                        // add details for monitor preview here
                    } else {
                        // add details for multiple monitor preview here
                    }
                });
            }

            base.$el.find("a").click(function () {
                if($(this).find("i").hasClass("fa-angle-down")) {
                    $(this).find("i").removeClass("fa-angle-down").addClass("fa-angle-right");
                } else {
                    $(this).find("i").removeClass("fa-angle-right").addClass("fa-angle-down");
                }
            });

            //SELECTING/DESELECTING ALL MONITORS
            $("#selectAll").on("click",function(){
                $(".monitor_overview input").each(function (index) {
                    var select = $("#selectAllDescription");
                    if(select.text() === " Deselect All"){
                        deselectTrigger = true;
                        $(this).trigger('click');
                    } else {
                        selectTrigger = true;
                        console.log("checked");
                        if(!$(this).is(":checked")) $(this).trigger('click');
                    }
                    console.log("triggered:" + selected);
                    if(selected === 0){
                        console.log("put");
                        deselectTrigger = false;
                        select.text(" Select All");
                    }
                    if(index === (monitors-1) && selectTrigger) {
                        selectTrigger = false;
                        select.text(" Deselect All");
                    }
                });
            });

            //FILTERING OF ALL LABELS
            $(".filter").on("click" ,function(){
                $(".monLi").hide();
                $("."+$(this).text()).show();
            });
        };
        // call init method
        base.init();
    };

    jQuery.fn.monitorModule = function (options) {
        return this.each(function () {
            new jQuery.monitorModule(this, options);
        });
    };
})(jQuery);