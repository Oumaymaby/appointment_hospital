$(document).ready(function() {
    $('#calendar').fullCalendar({
      header: {
				left: 'prev,next today',
				center: 'title', 
				right: 'agendaWeek'
			},
      select: function(start, end) {
				var eventData = {
						start: start,
						end: end
					};
					$('#calendar').fullCalendar('renderEvent', eventData, true);
			},
      slotDuration: '1:00',
      defaultView: 'agendaWeek',
      selectable: true,
			selectHelper: true,
      editable: true,
			eventLimit: true,
      slotEventOverlap: false,
      eventOverlap: false,
      minTime: '8:00:00',
      maxTime: '21:00:00',
      allDaySlot: false
    });
});