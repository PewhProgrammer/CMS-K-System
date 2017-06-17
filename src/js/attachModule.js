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

            var checked = 0 ;
            var url = "../php/attach.php";
            var ressourcesIncluded = [];
            var resourcesValIncluded = [];
            var monitors = $.getParameterByName('monitor');
            $('#chosenMonitor').text("You have chosen monitors " + monitors);
            var endTime = '2030-06-13 19:30:11'; //default indefinitely
            $("#ressourceList li input").change(function(){
                var dbId = this.id.substring(4,5) ;
                if(this.checked){
                    checked ++;
                    ressourcesIncluded.push(dbId)
                    resourcesValIncluded.push(this.value);
                }
                else{
                    checked --;
                    var index = ressourcesIncluded.indexOf(dbId);
                    var indexValue = resourcesValIncluded.indexOf(this.value);
                    if (index > -1) {
                        resourcesValIncluded.splice(indexValue, 1);
                        ressourcesIncluded.splice(index, 1);
                    }
                }

                console.log(resourcesValIncluded);

                //show/hide continue button
                if(checked > 0) $("#continueConfig").prop('disabled', false);
                else $("#continueConfig").prop('disabled', true);
            });

            $("#continueConfig").on("click",function(){
                var modalResourceList = $("#modalResourceList");
                modalResourceList.empty();
                for(var i = 0; i < resourcesValIncluded.length;i++ ){
                    modalResourceList.append('<br>');
                    modalResourceList.append('<i class="fa fa-check" aria-hidden="true" style="color:green"></i>'+
                            '<p style="padding-left:5em; display: inline-block;">' +
                        resourcesValIncluded[i]+'</p>');
                }
            });

            $("#attachSubmit").on("click",function(){
                $.post(url,{ resources:ressourcesIncluded, monitors: monitors,until: endTime }, function(data) {
                    alert("Response: " + JSON.stringify(data));
                });
            });
        }



        // call init method
        base.init();
    };

    jQuery.fn.attachModule = function (options) {
        return this.each(function () {
            new jQuery.attachModule(this, options);
        });
    };
})(jQuery);


