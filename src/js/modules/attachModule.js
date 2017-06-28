/**
 * Created by Thinh-Laptop on 01.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.attachModule = function (el, options) {
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

            base.$el.css("background-color", "white");

            var checked = 0;
            var url = "../php/attach.php";
            var ressourcesIncluded = [];
            var resourcesValIncluded = [];
            var monitors = "" + $.getParameterByName('m');
            var overview = false ;
            var timeSpanCheck = $('#timeSpanCheck');
            var timeSpan ;
            var datepicker = $("#datetimepicker1") ;
            var timeSpanText = $('#timeSpanText') ;
            var attachSubmit = $('#attachSubmit') ;
            var endTime = '2030-06-13 19:30:11'; //default indefinitely
            $("#resourceTable ").find("input").change(function () {
                var dbId = this.id.substring(4, 5);
                if (this.checked) {
                    checked++;
                    ressourcesIncluded.push(dbId)
                    resourcesValIncluded.push(this.value);
                }
                else {
                    checked--;
                    var index = ressourcesIncluded.indexOf(dbId);
                    var indexValue = resourcesValIncluded.indexOf(this.value);
                    if (index > -1) {
                        resourcesValIncluded.splice(indexValue, 1);
                        ressourcesIncluded.splice(index, 1);
                    }
                }
            });

            var monArray = monitors.split(",");
            //console.log(monArray);
            $.each(monArray,function(index,value){
               //console.log( index + ": " + value );
                if(value !== '')
                    $(".selectedMonitor."+value).show();
                else
                    overview = true;
            });

            $("#continueConfig").on("click", function () {
                var modalResourceList = $("#modalResourceList");
                modalResourceList.empty();
                for (var i = 0; i < resourcesValIncluded.length; i++) {
                    modalResourceList.append('<br>');
                    modalResourceList.append('<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' +
                        '<i style="font-weight:600;padding-left:1.5em; display: inline-block;">' +
                        resourcesValIncluded[i] + '</i>');
                }
            });


            attachSubmit.on("click", function () {
                console.log(ressourcesIncluded +" "+monitors+" "+endTime);
                $.post(url, {resources: ressourcesIncluded, monitors: monArray, until: endTime})
                    .done(function (data) {
                        window.location.replace('index.php?attach=success');
                    })
                    .fail(function () {
                        // failed
                    });
            });

            timeSpanCheck.on("click", function () {
                timeSpan = $('#timeSpan');
                if (this.checked) {
                    timeSpan.show();
                    validateFormat();
                } else {
                    endTime = '2030-06-13 19:30:11';
                    attachSubmit.prop('disabled',false);
                    timeSpan.hide();
                }
            });

            var dateNow = new Date();
            
            datepicker.datetimepicker({
                sideBySide: true,
                minDate: dateNow
            });

            datepicker.on("dp.change",function (e) { validateFormat();});

            timeSpanText.on('change', function() { validateFormat(); });


            //*               FUNCTION                *//

            function validateFormat(){
                var inputValue = timeSpanText.val() ;
                if(checkTimeFormat(inputValue)['status']){
                    endTime = checkTimeFormat(inputValue)['msg'];
                    //console.log(endTime);
                    attachSubmit.prop('disabled',false);
                }
                else {
                    attachSubmit.prop('disabled',true);
                }
            }

            function checkTimeFormat(timespan){
                //date;hour time;specifier
                var whiteSplit = timespan.split(" ");
                if(whiteSplit.length !== 3) return false;

                var date = whiteSplit[0].split("/");
                if(date.length !== 3) return false;

                var time = whiteSplit[1].split(":");
                if(time.length !== 2) return false;

                //time constraint
                if(parseInt(time[0]) > 12 || parseInt(time[0]) < 0) return false;

                if(whiteSplit[2] !== 'PM' && whiteSplit[2] !== 'AM') return false;


                //time format
                if(whiteSplit[2] === "PM") time[0] = " " + (parseInt(time[0]) + 12) ;
                var timeFormated = time[0] + ':' + time[1] + ':00' ;

                //date format
                var dateFormated = date[2] + '-' +  date[0] + '-' + date[1] ;

                //console.log(date);
                //console.log(time);
                //console.log(whiteSplit[2]);
                var until = dateFormated + ' ' + timeFormated;
                return {
                    status:true,
                    msg: until
                };
            }


        };


        // call init method
        base.init();
    };

    jQuery.fn.attachModule = function (options) {
        return this.each(function () {
            new jQuery.attachModule(this, options);
        });
    };
})(jQuery);


