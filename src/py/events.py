from urllib.request import urlopen
from bs4 import BeautifulSoup
from pprint import pprint

class Events:
    def __init__(self):
        pass

    def fetch_events(self):
        url = "http://www-intern.cispa.uni-saarland.de/wordpress/feed/atom"
        with urlopen(url) as f:
            xml = BeautifulSoup(f.read().decode(), "xml")

        for entry in xml.find_all("entry"):
            event = dict(
                category = entry.category["term"],
                title = entry.title.string,
                summary = entry.summary.string
            )
            pprint(event)



if (__name__ == "__main__"):
    events = Events()
    events.fetch_events()

        
