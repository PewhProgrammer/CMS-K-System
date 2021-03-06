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
            var horizontal = 0;
            var vertical = 0;
            var deselectTrigger = false;
            var selectTrigger = false;
            var select = $("#selectAllDescription");
            var monitorParam = "" + $.getParameterByName('m');
            var selectedID;

            base.$monID = -1000;

            base.$el.find(".monitor_overview").each(function () {
                monitors++;

                //TODO: Do we really need that code here?
                if ($(this).find("input").is(":checked")) {
                    $(this).css({"border-color": "#333333"});
                    selected++;
                }

            });

            $(".labelOption").on('click', function() {
                var lID = $(this).parent().find("p").html();
                $.post('../php/add.php', {
                    mID: selectedID,
                    lID: lID
                }).done(function (data) {
                    window.location.replace('index.php?m='+base.$monID);
                }).fail(function () {
                    console.log("New MonitorName failed");
                });
            });

            $("#addLabel").find("li").each(function() {
               $(this).find("i").click(function() {
                   var labID = $(this).parent().find("p").text();
                   $.post('../php/delete.php', {
                       labID: labID
                   }).done(function (data) {
                       //location.reload();
                       window.location.replace('index.php?m='+base.$monID+"&m=addLabel");
                   }).fail(function () {
                       console.log("Deleting Label failed");
                   });
               })
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

                        //count number of selected monitors and horizontal / vertical
                        selected++;
                        if($(this).parent().parent().hasClass("vertical")) {
                            vertical++;
                        } else {
                            horizontal++;
                        }

                        if(visibleSelected === monitorSelector.length && !selectTrigger) $("#selectAllDescription").text(" Deselect All");
                        else $("#selectAllDescription").text(" Select All");

                    } else {
                        $(this).parent().css({"border-color": "transparent"});

                        selected--;
                        if($(this).parent().parent().hasClass("vertical")) {
                            vertical--;
                        } else {
                            horizontal--;
                        }

                        if(!deselectTrigger)
                            $("#selectAllDescription").text(" Select All");
                    }

                    if (selected === 0) {
                        $("#previewPanel").fadeOut();
                        $(".monitorContainer").delay(400).animate({width: "100%"});
                    } else if (selected === 1) {
                        $(".monitorContainer").animate({width: "66%"});
                        $("#previewPanel").delay(400).fadeIn();

                        base.$el.find(".monitor_overview").each(function () {
                            if ($(this).find("input").is(":checked")) {
                                base.$monID = $(this).find(".monitorID").html();
                                selectedID =  base.$monID;
                                var monName = $(this).find(".monitorName").html();
                                var name = "Name: <span class='detailsName' style='font-weight: normal'>" + monName + "</span> <i id='editNameButton' class='glyphicon glyphicon-pencil'></i><br><br>";
                                var id = "Monitor ID: <span style='font-weight: normal'>" + base.$monID + "</span><br><br>";
                                var until ='';
                                var date = $(this).find("input").attr("data-until");
                                if(date !== undefined && date.split('-')[0] < '2030' && date.split('-')[0] >= '2017'){
                                    until = 'Until Date: <span style="font-weight: normal">' + $(this).find("input").attr("data-until") + '</span><br><br>';
                                }
                                var res = "Attached resource(s): <span style='font-weight: normal'>" + $(this).find(".resourceContent").html().slice(0, -2) + "</span><br><br>";

                                //find labels of the element
                                var labels = "";
                                var classList = $(this).parent().attr("class").split(" ");
                                //console.log('classes: ' + classList);
                                var customLabel = $(this).find("input").attr("data-label").split(" ");
                                for(var i = 3; i < classList.length-1; i++) {
                                    if(classList[i] === '') continue;
                                    labels += "<div class='labelbox'><i class='fa fa-tag aria-hidden=true'></i><span>"
                                        + classList[i] +'</span>';
                                    //console.log(customLabel[i-3]+" und " + 0);
                                    if(customLabel[i-3] !== '0'){
                                        labels += "<div id='removeLabelID"+i+"' class='labelRemoveBox'><i class='fa fa-times aria-hidden=true'></i></div>";
                                    }
                                    labels += "</div>";

                                }
                                var lab = "Labels: <span style='font-weight: normal'>"+ labels +"</span>"

                                $("#monDetails").html(name + id + res + until + lab);

                                //console.log('class Length: ' + classList.length);
                                for(var j = 4; j < classList.length; j++) {
                                    //console.log('class Length: ' + "#removeLabelID"+j);
                                    $("#removeLabelID"+j).on('click', function() {
                                        var labelSelector = $(this);
                                        var labelName = $(this).parent().text();
                                        $("#addLabel").find("li").each(function() {
                                            if($(this).find("a").text() === labelName) {
                                                //console.log("mID: " + selectedID + " lID: " + $(this).find("p").text());
                                                $.post('../php/delete.php', {
                                                    mID: selectedID,
                                                    lID: $(this).find("p").text()
                                                }).done(function (data) {
                                                    console.log("successful");
                                                    labelSelector.parent().css('display', 'none');
                                                    //console.log("#removeLabelID"+j);
                                                    //location.reload();
                                                }).fail(function () {
                                                    console.log("Deleting label from monitor failed");
                                                });
                                            }
                                        })
                                    });
                                }

                                $("#editNameButton").click(function() {
                                    var editName = "<p style='float: left; margin-right: 10px;'>Name: </p><span style='font-weight: normal'>"
                                        + "<input id='newMonName' class='form-control' value='"+ monName +"' name='newmonname' maxlength='255' type='text' autofocus>"
                                        + "<button id='submitNewMonName' class='btn btn-primary' type='submit' method='post'><i class='glyphicon glyphicon-ok' aria-hidden='true'></i></button>" + "</span><br><br>";
                                    $("#monDetails").html(editName + id + res + lab);

                                    $("#submitNewMonName").click(function() {
                                        if($("#newMonName").val().length < 1 || $("#newMonName").val().length > 255){
                                            return;
                                        }
                                        $.post('../php/update.php', {
                                            monID: base.$monID,
                                            newName: $("#newMonName").val()
                                        }).done(function (data) {
                                            window.location.replace('index.php?m='+base.$monID);
                                            ///location.reload();
                                        }).fail(function () {
                                            console.log("New MonitorName failed");
                                        });
                                    });
                                });
                            }
                        });
                    } else {
                        $("#monDetails").html("horizontal: <span style='font-weight: normal'>" + horizontal
                            + "</span><br><br>vertical: <span style='font-weight: normal'>" + vertical + "</span>");
                    }

                    //console.log('over');
                });
            }

            //check monitors from url parameters
            var monArray = monitorParam.split(",");
            for(var l = 0; l < monArray.length; l++){
                $('input[value="'+monArray[l]+'"]').prop("checked", true).trigger('change');
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
                var monitorSelector = $(".monLi.filter .monitor_overview input") ;
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
            var filterChecked = {};
            $(".filter.option").each(function(index){
                filterChecked[$(this).attr("id")] = "";
                console.log($(this).attr("id"));
            });

            $(".filter").on("click" ,function(){
                var thisSelector = $("."+$(this).text().replace(" Floor",".Floor"));
                //console.log("."+$(this).text().replace(" Floor",".Floor"));
                //keepFilterOption($(this).text());
                $(".monLi").hide();
                if(filterChecked[$(this).attr("id")] !== "" ){
                    filterChecked[$(this).attr("id")] = "";
                    $(this).html($(this).text());

                    thisSelector.removeClass("filter");
                    if(refreshFilterSelection())
                        filter();
                }else{
                    $(this).append(' <i class="fa fa-check" style="color:green" aria-hidden="true"></i>');
                    thisSelector.addClass("filter");

                    filterChecked[$(this).attr("id")] = $(this).text().replace(" Floor",".Floor").replace(" ","");
                    filter();
                    $(".monLi:not(.filter) .monitor_overview input").each(function () {
                        if($(this).is(":checked")) $(this).trigger('click');
                    });
                }
                $(".monLi.filter").show();
                refreshSelectButton();
                displayWarning();
            });
            var warningAlertID = $("#warning-alert");

            function displayWarning(){
                if($(".monLi.filter").length === 0){
                    //display warning
                    warningAlertID.alert();
                    $("#alertWarningText").text('There are no monitors with the applied filter options.');

                    warningAlertID.fadeTo(6000, 1000).slideUp(500, function () {
                        warningAlertID.slideUp(500);
                    });
                }
            }

            //add class filter to all monitors not respecting the filter options
            function filter(){
                var selectionBuilder = '.monLi:not(';
                for (var key in filterChecked) {
                    if (filterChecked.hasOwnProperty(key)) {
                        if(filterChecked[key] !== "")
                        selectionBuilder += '.'+filterChecked[key].replace(" Floor",".Floor").replace(/ /g,'');
                    }
                }
                selectionBuilder += ')';
                //console.log("built: " +selectionBuilder);
                $(selectionBuilder).removeClass("filter");
            }

            function refreshFilterSelection(){
                var filterOn = false;
                $(".filter.option").each(function(index){

                    if(filterChecked[$(this).attr("id")] !== ""){
                        filterOn = true;
                        var monitorSelector = $('.'+$('#'+$(this).attr("id")).text().replace(" Floor",".Floor").replace(/ /g,''));
                        monitorSelector.addClass('filter');
                    }
                });
                if(!filterOn){
                    //console.log("entry");
                    $(".monLi").addClass("filter");
                    refreshSelectButton();
                    return false;
                }
                return true;
            }

            $("#filterAll").on("click" ,function(){
                //keepFilterOption('Filter');
                $(".monLi").addClass("filter");
                $(".monLi").show();
                refreshSelectButton();
                for (var key in filterChecked) {
                    if (filterChecked.hasOwnProperty(key)) {
                        filterChecked[key] = "" ;
                    }
                }
                $(".filter.option").each(function(){
                    $(this).html($(this).text());
                });
            });

            function refreshSelectButton(){
                var monitorSelector = $(".monitor_overview:visible input") ;
                var visibleSelected = 0 ;
                $(".monLi:visible").each(function() {
                    if($(this).find("input").is(":checked")) visibleSelected++ ;
                });
                //console.log("visible: " + visibleSelected + ", " + (monitorSelector.length));
                if(visibleSelected < (monitorSelector.length)) {
                    select.text(" Select All");
                }
                else select.text(" Deselect All");
            }

            //console.log('cold: ' + monArray[1]);
            if(monArray[1] === 'addLabel'){
                console.log("lol");
                $('#buttonAddLabel').click();
            }

            $("#submitLabelButton").click(function(e) {
                if($('#labelNameInput').val().length < 1 || $('#labelNameInput').val().length > 255){
                    return;
                }
               var newLabel = $(this).parent().find("input").val();
               //console.log("processing addLabel " + newLabel);
                $.post('../php/add.php', {
                    newLabel: newLabel
                }).done(function (data) {
                    //$(".dropdown-menu#addLabel").prepend('<li><a class="labelOption" href="#">'+newLabel+'</a></li>');
                    //location.reload();
                    window.location.replace('index.php?m='+base.$monID+"&m=addLabel");
                }).fail(function () {
                    console.log("New Label failed");
                });
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