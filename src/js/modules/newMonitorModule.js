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

            //console.log("new Monitor running");

            $(".unregisteredMonitors").on('click',function(data){
               console.log('clicked on: ' + $(this).attr('data-value'));
               console.log('date: ' + $(this).attr('data-time'));

               $('#newMonitorIDModal').text($(this).attr('data-value'));
               $('#newMonitorModal').modal();
            });

            $("#newMonPrefixDrop").find('li').find('a').click(function () {
               console.log('clicked: ' + $(this).text());

               var btnSelector = $("#dropdownMenuNewMon");
               btnSelector.text($(this).text());
               btnSelector.append(' <i class="fa fa-caret-down"></i>');
            });

            $("#dropdownMenuAlignment").click(function(){
                if($(this).text().replace(" ","").startsWith('vertical')) {
                    $(this).val(0); // 0 = vertical | 1 = horizontal
                    $(this).text('horizontal');
                }
                else {
                    $(this).val(1);
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


