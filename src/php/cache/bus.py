# -*- coding: utf-8 -*-
from www import fetch_url
from bs4 import BeautifulSoup
import datetime
from www import fetch_url
import json
import dateutil.parser


class SaarVV:
    def __init__(self):
        self.n = 12

    def get_schedule(self):
        schedule = self.load_schedule_from_cache()
        if (schedule):
            now = datetime.datetime.now()
            schedule = self.filter_schedule(schedule, now)
            time = dateutil.parser.parse(schedule["time"])
            if (len(schedule["busses"]) >= self.n and now - time < datetime.timedelta(minutes = 5)):
                schedule["from_cache"] = True
                return schedule
        schedule = self.fetch_schedule()
        self.save_schedule_to_cache(schedule)
        schedule["from_cache"] = False
        return schedule

    def load_schedule_from_cache(self):
        try:
            with open("bus_1.json", "rt") as f:
                return json.load(f)
        except FileNotFoundError:
            return None

    def save_schedule_to_cache(self, schedule):
        with open("bus_1.json", "wt") as f:
            json.dump(schedule, f)

    def filter_schedule(self, schedule, now):
        def bus_time_filter(bus):
            return now - dateutil.parser.parse(bus["time"]) < datetime.timedelta(minutes = 5)
        schedule["busses"] = list(filter(bus_time_filter, schedule["busses"]))
        return schedule

    def fetch_schedule(self):
        bus_stop = 10906 # Stuhlsatzenhaus
        time = datetime.datetime.now()
        url = "http://www.saarfahrplan.de/cgi-bin/stboard.exe/dn?input={bus_stop}&boardType=dep&time={time:%H:%M}&maxJourneys={max_journeys:d}&dateBegin={date_begin:%d.%m.%Y}&dateEnd={date_end:%d.%m.%Y}&selectDate=today&productsFilter=1:1111111111&start=yes&pageViewMode=PRINT&dirInput=&".format(bus_stop = bus_stop, time = time.time(), date_begin = time.date(), date_end = time.date() + datetime.timedelta(days = 2), max_journeys = self.n * 2)
        #print(url)
        html = fetch_url(url, encoding = "latin_1")
        soup = BeautifulSoup(html, "html.parser")

        def parse_time(s):
            return datetime.datetime.combine(time.date(), datetime.datetime.strptime(s, "%H:%M").time())

        table = soup.find_all(class_ = "hafasResult")[1]
        keys = [th.string for th in table.find_all("th")]

        busses = []
        for t in soup.find_all(class_ = ["depboard-dark", "depboard-light"]):
            row = {}
            for i, td in enumerate(t.find_all("td")):
                row[keys[i]] = td

            field_delay = row.get("Prognose")
            if (not field_delay or not field_delay.span or field_delay.span.string == "pünktl."):
                delay = 0
            #elif (tuple(field_delay.span.stripped_strings)[0] == "Fahrt fällt aus"):
            #    delay = "cancelled"
            else:
                #print(list(field_delay.span.stripped_strings))
                s_delay = field_delay.span.string.split()[0];
                try:
                    delay = int(s_delay)
                except ValueError:
                    print("Could not parse delay:", s_delay)
                    delay = 0

            destination, stops_str = row["In Richtung"].stripped_strings
            stops = []
            stop = None
            for i, line in enumerate(stops_str.splitlines()):
                if (i % 3 == 0):
                    stop = line
                elif (i % 3 == 1):
                    stops.append({"stop": stop, "time": parse_time(line).isoformat()})

            #print(list(row["Fahrt"].stripped_strings))
        
            busses.append(dict(
                time = parse_time(row["Zeit"].string.strip()).isoformat(),
                delay = delay,
                line = tuple(row["Fahrt"].stripped_strings)[0],
                destination = destination,
                stops = stops,
                station = next(row["Gleis/Haltestelle"].strings).strip()
            ))

        return {
            "bus_stop": bus_stop,
            "time": time.isoformat(),
            "source": url,
            "busses": busses
        }

if (__name__ == "__main__"):
    from pprint import pprint
    saarvv = SaarVV()
    pprint(saarvv.get_schedule())
