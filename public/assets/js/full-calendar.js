//
// Widget Calendar
//


//
// full calendar
//

if (document.querySelector('[data-toggle="calendar"]')) {

  var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
    contentHeight: 'auto',
    initialView: "dayGridMonth",
    headerToolbar: {
      start: 'title', // will normally be on the left. if RTL, will be on the right
      center: '',
      end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
    },
    selectable: true,
    editable: true,
    initialDate: '2020-12-01',
    events: [{
        title: 'Call with Dave',
        start: '2022-12-18',
        end: '2022-12-18',
        className: 'bg-gradient-to-tl from-red-600 to-rose-400'
      },

      {
        title: 'Lunch meeting',
        start: '2022-12-21',
        end: '2022-12-22',
        className: 'bg-gradient-to-tl from-red-500 to-yellow-400'
      },

      {
        title: 'All day conference',
        start: '2022-12-29',
        end: '2022-12-29',
        className: 'bg-gradient-to-tl from-green-600 to-lime-400'
      },

      {
        title: 'Meeting with Mary',
        start: '2020-12-01',
        end: '2020-12-01',
        className: 'bg-gradient-to-tl from-blue-600 to-cyan-400'
      },

      {
        title: 'Winter Hackaton',
        start: '2020-12-03',
        end: '2020-12-03',
        className: 'bg-gradient-to-tl from-red-600 to-rose-400'
      },

      {
        title: 'Digital event',
        start: '2020-12-07',
        end: '2020-12-09',
        className: 'bg-gradient-to-tl from-red-500 to-yellow-400'
      },

      {
        title: 'Marketing event',
        start: '2020-12-10',
        end: '2020-12-10',
        className: 'bg-gradient-to-tl from-purple-700 to-pink-500'
      },

      {
        title: 'Dinner with Family',
        start: '2020-12-19',
        end: '2020-12-19',
        className: 'bg-gradient-to-tl from-red-600 to-rose-400'
      },

      {
        title: 'Black Friday',
        start: '2020-12-23',
        end: '2020-12-23',
        className: 'bg-gradient-to-tl from-blue-600 to-cyan-400'
      },

      {
        title: 'Cyber Week',
        start: '2020-12-02',
        end: '2020-12-02',
        className: 'bg-gradient-to-tl from-red-500 to-yellow-400'
      },

    ],
    views: {
      month: {
        titleFormat: {
          month: "long",
          year: "numeric"
        }
      },
      agendaWeek: {
        titleFormat: {
          month: "long",
          year: "numeric",
          day: "numeric"
        }
      },
      agendaDay: {
        titleFormat: {
          month: "short",
          year: "numeric",
          day: "numeric"
        }
      }
    },
  });

  calendar.render();
}
