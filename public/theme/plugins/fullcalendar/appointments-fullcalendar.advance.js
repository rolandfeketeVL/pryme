$(document).ready(function() {

    // Get the modal
    var modal = document.getElementById("addEventsModal");

    // Get the button that opens the modal
    //var btn = document.getElementById("myBtn");

    // Get the Add Event button
    var addEvent = document.getElementById("add-e");
    // Get the Edit Event button
    var editEvent = document.getElementById("edit-event");
    // Get the Edit Event button
    var deleteEvent = document.getElementById("delete-event");
    // Get the Discard Modal button
    var discardModal = document.querySelectorAll("[data-dismiss='modal']")[0];
    //Get register button
    var registerButton = document.getElementById("register");
    //Get unregister button
    var unregisterButton = document.getElementById("delete-appointment");
    //Get registered message
    var registeredMessage = document.getElementById("registered-message");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Get the all <input> elements insdie the modal
    var input = document.querySelectorAll('input[type="text"]');
    var radioInput = document.querySelectorAll('input[type="radio"]');

    // Get the all <textarea> elements insdie the modal
    var textarea = document.getElementsByTagName('textarea');

    // var recursive_row = document.getElementById('recursive-row');
    // var recursive_checkbox = document.getElementById('recursive-checkbox');

    // Create BackDrop ( Overlay ) Element
    function createBackdropElement () {
        var btn = document.createElement("div");
        btn.setAttribute('class', 'modal-backdrop fade show')
        document.body.appendChild(btn);
    }

    // Reset radio buttons

    function clearRadioGroup(GroupName) {
      var ele = document.getElementsByName(GroupName);
        for(var i=0;i<ele.length;i++)
        ele[i].checked = false;
    }

    // Reset Modal Data on when modal gets closed
    function modalResetData() {
        modal.style.display = "none";
        for (i = 0; i < input.length; i++) {
            input[i].value = '';
        }
        for (j = 0; j < textarea.length; j++) {
            textarea[j].value = '';
          i
        }
        clearRadioGroup("name");
        // Get Modal Backdrop
        var getModalBackdrop = document.getElementsByClassName('modal-backdrop')[0];
        document.body.removeChild(getModalBackdrop)
    }

    // Clear Data and close the modal when the user clicks on Discard button
    discardModal.onclick = function() {
        modalResetData();
        document.getElementsByTagName('body')[0].removeAttribute('style');
    }

    // Clear Data and close the modal when the user clicks on <span> (x).
    span.onclick = function() {
        modalResetData();
        document.getElementsByTagName('body')[0].removeAttribute('style');
    }

    // Clear Data and close the modal when the user clicks anywhere outside of the modal.
    window.onclick = function(event) {
        if (event.target == modal) {
            modalResetData();
            document.getElementsByTagName('body')[0].removeAttribute('style');
        }
    }



    /* initialize the calendar
    -----------------------------------------------------------------*/

    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: eventsList,
        editable: true,
        eventLimit: true,
        eventMouseover: function(event, jsEvent, view) {
            $(this).attr('id', event.id);

            $('#'+event.id).popover({
                template: '<div class="popover popover-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                title: event.title,
                content: event.description,
                placement: 'top',
            });

            $('#'+event.id).popover('show');
        },
        eventMouseout: function(event, jsEvent, view) {
            $('#'+event.id).popover('hide');
        },
        eventClick: function(info) {

            modal.style.display = "block";
            document.getElementsByTagName('body')[0].style.overflow = 'hidden';
            createBackdropElement();

            // Calendar Event Fetch
            var eventTitle = info.title;
            var eventID = info.id;
            var eventDescription = info.description;
            var linkContent = info.link;
            var appointed = info.appointed;

            // Task Modal Input
            var taskTitle = $('#event-name');
            var taskTitleValue = taskTitle.html(eventTitle);

            var taskID = $("#eventId");
            var eventIdValue = taskID.val(eventID)

            var linkObj = $("#link");
            var linkValue = linkObj.val(linkContent);

            var trainerName = $('#trainer-name');
            var trainerNameValue = trainerName.html(eventDescription);

            var taskInputStarttDate = $("#start-date");
            var taskInputStarttDateValue = taskInputStarttDate.val(info.start.format("YYYY-MM-DD HH:mm:ss"));

            var taskInputEndDate = $("#end-date");
            var taskInputEndtDateValue = taskInputEndDate.val(info.end.format("YYYY-MM-DD HH:mm:ss"));

            if(appointed == 1) {
                registerButton.style.display = "none";
                unregisterButton.style.display = "block";
                registeredMessage.style.display = "block";
            }


            // $('#edit-event').off('click').on('click', function(event) {
            //     event.preventDefault();
            //     /* Act on the event */
            //     var radioValue = $("input[name='name']:checked").val();
            //
            //
            //     var taskStartTimeValue = document.getElementById("start-date").value;
            //     var taskEndTimeValue = document.getElementById("end-date").value;
            //
            //     info.title = taskTitle.val();
            //     info.link = linkObj.val();
            //     info.id = taskID.val();
            //     info.description = taskDescription.val();
            //     info.start = taskStartTimeValue;
            //     info.end = taskEndTimeValue;
            //     info.className = radioValue;
            //
            //     $('#calendar').fullCalendar('updateEvent', info);
            //     modal.style.display = "none";
            //     modalResetData();
            //     document.getElementsByTagName('body')[0].removeAttribute('style');
            // });
        }
    })


    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
        return result;
    }

    // Setting dynamic style ( padding ) of the highlited ( current ) date

    function setCurrentDateHighlightStyle() {
        getCurrentDate = $('.fc-content-skeleton .fc-today').attr('data-date');
        if (getCurrentDate === undefined) {
            return;
        }
        splitDate = getCurrentDate.split('-');
        if (splitDate[2] < 10) {
            $('.fc-content-skeleton .fc-today .fc-day-number').css('padding', '3px 8px');
        } else if (splitDate[2] >= 10) {
            $('.fc-content-skeleton .fc-today .fc-day-number').css('padding', '3px 4px');
        }
    }
    setCurrentDateHighlightStyle();

    const mailScroll = new PerfectScrollbar('.fc-scroller', {
        suppressScrollX : true
    });
    
    // var fcButtons = document.getElementsByClassName('fc-button');
    // for(var i = 0; i < fcButtons.length; i++) {
    //     fcButtons[i].addEventListener('click', function() {
    //         const mailScroll = new PerfectScrollbar('.fc-scroller', {
    //             suppressScrollX : true
    //         });
    //         $('.fc-scroller').animate({ scrollTop: 0 }, 100);
    //         setCurrentDateHighlightStyle();
    //     })
    // }


});