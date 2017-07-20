/**
 * Created by Thinh-Laptop on 01.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.newMonitorModule = function (el, options) {
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

            base.$alignment = 2;
            base.$location = 3;
            base.$mID;

            //console.log("new Monitor running");

            $(".unregisteredMonitors").on('click',function(data){
               console.log('clicked on: ' + $(this).attr('data-value'));
               console.log('date: ' + $(this).attr('data-time'));

               $('#newMonitorIDModal').text($(this).attr('data-value'));
               base.$mID = $(this).attr('data-value');
               $('#newMonitorModal').modal();
            });

            $("#newMonPrefixDrop").find('li').find('a').click(function () {
               console.log('clicked: ' + $(this).attr('data-value'));
               base.$location = $(this).attr('data-value');

               var btnSelector = $("#dropdownMenuNewMon");
               btnSelector.text($(this).text());
               btnSelector.append(' <i class="fa fa-caret-down"></i>');
            });

            $("#newMonitorSubmit").click(function(){
                console.log("new monitor submitted");
                var monName = $("#newMonitorInput").val() ;
                if(monName.length < 1) {
                    console.log('its fault');
                    return;
                }
                else console.log('good job');

                console.log('align: ' + base.$alignment +"; location: " + base.$location);
                $.post("../php/newMonitor.php", {alignment:base.$alignment,location:base.$location,name:monName,mID:base.$mID})
                    .done(function (data) {
                        //console.log(JSON.parse(data)['code'] === 200);
                        if(JSON.parse(data)['code'] === 200){
                            window.location.replace('index.php?newMonitor=success');
                        }
                        else
                        window.location.replace('index.php?newMonitor=failed');

                    })
                    .fail(function () {
                        window.location.replace('index.php?newMonitor=failed');
                    });
            });

            $("#dropdownMenuAlignment").click(function(){
                if($(this).text().replace(" ","").startsWith('vertical')) {
                    base.$alignment = 2;
                    $(this).text('horizontal');
                }
                else {
                    base.$alignment = 1;
                    $(this).text('vertical');
                }

            });

        };


        // call init method
        base.init();
    };

    jQuery.fn.newMonitorModule = function (options) {
        return this.each(function () {
            new jQuery.newMonitorModule(this, options);
        });
    };
})(jQuery);


