/**
 * Roles Form Api
 */

$(function (e) {

    $("#select_all").on("click", function (e) {

        if($(this).is(":checked")) {
            $(".permission").iCheck('check');
        } else {
            $(".permission").iCheck('uncheck');
        }
    });

});