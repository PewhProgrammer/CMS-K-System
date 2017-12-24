


function data_req (url, callback) {
    req = new XMLHttpRequest()
    req.addEventListener('load', callback)
    req.open('GET', url)
    req.send()
}

function add_recur_events() {
    if (sources_to_load_cnt < 1) {
        $('#calendar').fullCalendar('addEventSource', expand_recur_events)
    } else {
        setTimeout(add_recur_events, 30)
    }
}

function load_ics(ics){
    data_req(ics.url, function(){
        $('#calendar').fullCalendar('addEventSource', fc_events(this.response, ics.event_properties))
        sources_to_load_cnt -= 1
    })
}

$('#calendar').fullCalendar({
    defaultView: 'agenda',
    visibleRange: function (currentDate) {
        return {
            start: currentDate.clone().subtract(0, 'days'),
            end: currentDate.clone().add(7, 'days') // exclusive end, so 5
        };
    },
    header: {
        left: '',
        center: 'title',
        right: ''
    },
    nowIndicator: true,
    weekends: false,
    heightContent: "auto",
    height: "auto",
    minTime: "07:00:00",
    maxTime: "21:00:00",
    allDaySlot: false,
    editable: false,
    columnFormat: 'ddd',
    displayEventTime: true,// Display event time
    events: function (start, end, timezone, callback) {
        var events = [
            {
                title: 'Meeting with P002',
                start: '2017-07-10T08:00:00',
                allday: false
            },
            {
                title: 'Review of current master project',
                start: '2017-07-11T12:00:00',
                allday: false
            }, {
                title: 'Food with the Janosch',
                start: '2017-07-13T13:40:00',
                allday: false
            },
            {
                title: 'Hanging out with the Janosch',
                start: '2017-07-13T17:00:00',
                allday: false
            }, {
                title: 'Netflix',
                start: '2017-07-14T15:30:00',
                allday: false
            }];
        events.push({
            title: 'This is a Material Design event!',
            start: '2015-11-20T08:30:00',
            end: '2015-11-20T08:30:00',
            color: '#C2185B'
        })
        callback(events);
    }
});
    sources_to_load_cnt = ics_sources.length
    for (ics of ics_sources) {
        load_ics(ics)
    }
    add_recur_events()

