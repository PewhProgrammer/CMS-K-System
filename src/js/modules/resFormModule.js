/**
 * Created by Marc on 19.06.2017.
 */

(function (jQuery) {
    "use strict";

    jQuery.resFormModule = function (el, options) {
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

            var selected = 0;

            base.$el.find(".k-selectable").each(function () {
                if ($(this).find("input").is(":checked")) {
                    $(this).parent().parent().css({"background-color": "blanchedalmond"});
                    selected++;
                }
            });

            base.$el.find(".k-selectable").find("input").change(function () {
                if (this.checked) {
                    $(this).parent().parent().parent().css({"background-color": "blanchedalmond"});
                    selected++;
                } else {
                    $(this).parent().parent().parent().css({"background-color": "transparent"});
                    selected--;
                }

                if (selected === 0) {
                    $("#previewPanel").fadeOut();
                    $("#resForm").delay(400).animate({width: "100%"});
                } else if (selected === 1) {
                    $("#resForm").animate({width: "66%"});
                    $("#previewPanel").delay(400).fadeIn();
                    // add details for monitor preview here
                } else {
                    // add details for multiple monitor preview here
                }
            });


            document.getElementById("sortNameDown").onclick = function() {sortTable(0, 'down');};
            document.getElementById("sortNameUp").onclick = function() {sortTable(0, 'up');};
            document.getElementById("sortTypeDown").onclick = function() {sortTable(1, 'down');};
            document.getElementById("sortTypeUp").onclick = function() {sortTable(1, 'up');};

            base.$el.find(".fa-trash-o").click(function() {
                console.log("deleting: " + $(this).data("id"));

                $.post('../php/delete.php', {
                    id: $(this).data("id")
                }).done(function (data) {
                    $("#successInput").text('Deleted');
                    $("#success").show();
                }).fail(function () {

                });

            });

        };
        // call init method
        base.init();
    };

    jQuery.fn.resFormModule = function (options) {
        return this.each(function () {
            new jQuery.resFormModule(this, options);
        });
    };
})(jQuery)

//slightly adjusted exmaple from w3schools
function sortTable(column, direction) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("resourceTable");
    switching = true;
    /*Make a loop that will continue until
     no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.getElementsByTagName("TR");
        /*Loop through all table rows (except the
         first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
             one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[column];
            y = rows[i + 1].getElementsByTagName("TD")[column];
            //check if the two rows should switch place:
            var xInner, yInner;
            if(column === 0) {
                xInner = x.getElementsByTagName("p")[0].innerHTML.toLowerCase();
                yInner = y.getElementsByTagName("p")[0].innerHTML.toLowerCase();
            } else {
                xInner = x.innerHTML.toLowerCase();
                yInner = y.innerHTML.toLowerCase();
            }
            if (direction === "down" && xInner > yInner) {
                //if so, mark as a switch and break the loop:
                shouldSwitch= true;
                break;
            } else if (direction === "up" && yInner > xInner) {
                shouldSwitch= true;
                break;
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
             and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}