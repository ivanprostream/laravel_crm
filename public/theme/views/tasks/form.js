/**
 * Contacts Form Api
 */

$(function () {

    $("#documents").select2();
    $('#assigned_users').select2();
    $('#assigned_divisions').select2();

    $('.textarea').summernote({
        height: 200,
    })

    $("#start_date, #end_date").datepicker({
        firstDay: 1,
        closeText: "Закрыть",
        prevText: "&#x3C;",
        nextText: "&#x3E;",
        currentText: "Сегодня",
        monthNames: [ "Январь","Февраль","Март","Апрель","Май","Июнь",
        "Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь" ],
        monthNamesShort: [ "Янв","Фев","Мар","Апр","Май","Июн",
        "Июл","Авг","Сен","Окт","Ноя","Дек" ],
        dayNames: [ "воскресенье","понедельник","вторник","среда","четверг","пятница","суббота" ],
        dayNamesShort: [ "вск","пнд","втр","срд","чтв","птн","сбт" ],
        dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ],
        weekHeader: "Нед",
    });

    $("#custom-tabs-assigned").on("click", "#assigned_users-tab", function(){
        $("select#assigned_divisions").val(null).trigger('change');
    });

    $("#custom-tabs-assigned").on("click", "#assigned_divisions-tab", function(){
        $("select#assigned_users").val(null).trigger('change');
    });

});


/**
 * get Contacts
 *
 *
 * @param status
 * @param selected_contact_id
 */
var getContacts = function (status, selected_contact_id)
{
    $.ajax({
        url: $("#getContactsAjaxUrl").val(),
        data: {status: status},
        method: "GET",
        dataType: "json",
        success: function (response) {
            if(response.length > 0) {
                for(var i=0; i<response.length; i++) {
                    $("#contact_id").append('<option value="'+ response[i].id +'" ' + (selected_contact_id == response[i].id?'selected':'') + '>'+ response[i].first_name + (response[i].middle_name != null?' ' + response[i].middle_name + ' ':' ') + (response[i].last_name!=null? response[i].last_name:'') + '</option>');
                }
            }
        }
    });
};