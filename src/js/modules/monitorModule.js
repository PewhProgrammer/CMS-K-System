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
            var select = $("#selectAllDescription");

            base.$el.find(".monitor_overview").each(function () {
                monitors++;
                if ($(this).find("input").is(":checked")) {
                    $(this).css({"border-color": "#333333"});
                    selected++;
                }
            });

            for(var i = 0; i < monitors; i++) {
                $("#monInput-"+i).change(function() {
                    var monitorSelector = $(".monitor_overview:visible input") ;
                    var visibleSelected = 0 ;
                    $(".monLi:visible").each(function() {
                        if($(this).find("input").is(":checked")) visibleSelected++ ;
                    });

                    if (this.checked) {
                        $(this).parent().css({"border-color": "#333333"});
                        selected++;
                        if(visibleSelected === monitorSelector.length && !selectTrigger) $("#selectAllDescription").text(" Deselect All");
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

                        base.$el.find(".monitor_overview").each(function () {
                            if ($(this).find("input").is(":checked")) {
                                var html;
                                html = "Name: <span style='font-weight: normal'>" + $(this).find(".monitorName").html() + "</span><br><br>";
                                html = html + "Attached resource(s): <span style='font-weight: normal'>" + $(this).find(".resourceContent").html().slice(0, -2) + "</span>";
                                $("#previewPanel").find("p").html(html);
                            }
                        });
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

            //When collapsing is done
            $('.panel-collapse').on('hidden.bs.collapse', function () {
                var monitorSelector = $(".monitor_overview:visible input") ;
                var visibleSelected = 0 ;
                $(".monLi:visible").each(function() {
                    if($(this).find("input").is(":checked")) visibleSelected++ ;
                });

                if(visibleSelected === monitorSelector.length && monitorSelector.length !== 0) {
                    select.text(" Deselect All");
                } else select.text(" Select All");
            });

            //When un-collapsing is done
            $('.panel-collapse').on('shown.bs.collapse', function () {
                refreshSelectButton();
            });

            //SELECTING/DESELECTING ALL MONITORS
            $("#selectAll").on("click",function(){
                var monitorSelector = $(".monLi:not(.filter) .monitor_overview input") ;
                monitorSelector.each(function (index) {
                    if(select.text() === " Deselect All"){
                        deselectTrigger = true;
                        $(this).trigger('click');
                    } else {
                        selectTrigger = true;
                        if(!$(this).is(":checked")) $(this).trigger('click');
                    }
                    if(index === (monitorSelector.length-1) && deselectTrigger){
                        deselectTrigger = false;
                        select.text(" Select All");
                    }
                    if(index === (monitorSelector.length-1) && selectTrigger) {
                        selectTrigger = false;
                        select.text(" Deselect All");
                    }
                });
            });

            //FILTERING OF ALL LABELS
            $(".filter").on("click" ,function(){
                keepFilterOption($(this).text());
                $(".monLi").addClass("filter");
                $(".monLi").hide();
                $("."+$(this).text().replace(" ",".")).show();
                $("."+$(this).text().replace(" ",".")).removeClass("filter");
                var monitorSelector = $(".monLi.filter .monitor_overview input") ;
                //select.text(" Select All");
                monitorSelector.each(function () {
                    if($(this).is(":checked")) $(this).trigger('click');
                    //$(this).prop("checked",false);
                });
                refreshSelectButton()
            });
            $("#filterAll").on("click" ,function(){
                keepFilterOption('Filter');
                $(".monLi").removeClass("filter");
                $(".monLi").show();
                refreshSelectButton();
            });

            function keepFilterOption(label){
                var btnSelector = $("#dropdownMenu") ;
                btnSelector.text("");
                btnSelector.append(' <i class="fa fa-filter" aria-hidden="true"></i> ');
                btnSelector.append(label);
                btnSelector.val(label);
                btnSelector.append(' <span class="caret"></span> ');
            }

            function refreshSelectButton(){
                var monitorSelector = $(".monitor_overview:visible input") ;
                var visibleSelected = 0 ;
                $(".monLi:visible").each(function() {
                    if($(this).find("input").is(":checked")) visibleSelected++ ;
                });
                console.log("visible: " + visibleSelected + ", " + (monitorSelector.length));
                if(visibleSelected < (monitorSelector.length)) {
                    select.text(" Select All");
                }
                else select.text(" Deselect All");
            }
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