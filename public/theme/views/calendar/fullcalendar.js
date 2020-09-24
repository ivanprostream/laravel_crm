/**
 * Full calendar Api
 *
 */
$(function () {

    $('#calendar').fullCalendar({
        header    : {
            left  : 'prev,next today',
            center: 'title',
            right : 'month,agendaWeek,agendaDay'
        },
        monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','οюнь','οюль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
        dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
        dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
        buttonText: {
            today: 'Сегодня',
            month: 'Месяц',
            week : 'Неделя',
            day  : 'День'
        },
        //Random default events
        events    : events,
        editable  : true,
        eventClick: function(info) {
            console.log(info);

            $("#modal-default").find("h4.modal-title").text(info.title);

            $("#modal-default").find(".modal-body p").html(info.description);

            $("#modal-default").modal("show");
        }
    });


    // show or hide events based on category
    $(".bg-pink").on("click", function (e) {

        $('.fc-event-container a.pending').toggle();
    });

    $(".bg-blue").on("click", function (e) {

        $('.fc-event-container a.in-progress').toggle();
    });

    $(".bg-green").on("click", function (e) {

        $('.fc-event-container a.finished').toggle();
    });

});