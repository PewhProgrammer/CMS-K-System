ics_sources = [
    {
        url: '../uploads/feiertage.ics',
        event_properties: {
            color: 'gold'
        }
    }
]


function data_req(url, callback) {
    req = new XMLHttpRequest()
    req.addEventListener('load', callback)
    console.log(url);
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

function load_ics(ics) {
    data_req(ics.url, function () {
        $('#calendar').fullCalendar('addEventSource', fc_events(this.response, ics.event_properties))
        sources_to_load_cnt -= 1
    })
}

$(document).ready(function () {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        defaultDate: '2016-03-01'
    })
    sources_to_load_cnt = ics_sources.length
    for (ics in ics_sources) {
        console.log("yolo: "+ ics);
        load_ics(ics)
    }
    add_recur_events()
})