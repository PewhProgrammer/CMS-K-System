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

            function getParameterByName(name, url) {
                if (!url) url = window.location.href;

                name = name.replace(/[\[\]]/g, "\\$&");
               /* var regex = new RegExp("[?&]" + name + "(=([^"+ name +"#]*)|&|#|$|)"),
                    results = regex.exec(url);*/
                var results = url.split(name+"=");
                results.splice(0, 1);
                for (var i = 0; i < results.length; i++) {
                    results[i] = results[i].replace(/[^0-9.]/g, "");
                }
                if (!results) return null;
                if (!results[1]) return '';
                return results;
            }

            var checked = 0 ;
            var url = "../php/attach.php";
            var ressourcesIncluded = [];
            var monitors = getParameterByName('monitor');
            console.log("Selected monitors: " + monitors);
            $("#ressourceList li input").change(function(){
                var dbId = this.id.substring(4,5) ;
                if(this.checked){
                    checked ++;
                    ressourcesIncluded.push(dbId)
                }
                else{
                    checked --;
                    var index = ressourcesIncluded.indexOf(dbId);
                    if (index > -1) {
                        ressourcesIncluded.splice(index, 1);
                    }
                }

                console.log("Updated resourceList: " +ressourcesIncluded);

                $.post(url,{ resources:ressourcesIncluded, monitors: monitors }, function(data) {
                    alert("Response: " + JSON.stringify(data));
                });

                //show/hide continue button
                if(checked > 0) $("#continueConfig").prop('disabled', false);
                else $("#continueConfig").prop('disabled', true);
            });

            $("#continueConfig").on("click",function(){
                //console.log("click");
            });

            $("#attachSubmit").on("click",function(){
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


