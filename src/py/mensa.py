from io import TextIOWrapper
import json
from datetime import datetime, timedelta
import dateutil.parser
from www import fetch_url



class Mensa:
    def __init__(self, api_version = 1, app_version = 1, language = "de"):
        self.api_key = "ZQ9E0kZx9IXp6xcY6ryJ"
        self.cache_timeout = timedelta(minutes = 5)
        self.app_version = app_version
        self.language = language
        self.base_url = "https://mensaar.de/api/{}/{}/{}/{}/".format(api_version, self.api_key, app_version, language)

    def get_menu(self):
        menu = self.load_menu_from_cache()
        if (menu):
            time = dateutil.parser.parse(menu["time"])
            if (datetime.now() - time < self.cache_timeout):
                menu["from_cache"] = True
                return menu
        menu = self.fetch_menu()
        menu["from_cache"] = False
        self.save_menu_to_cache(menu)
        return menu

    def load_menu_from_cache(self):
        try:
            with open("cache/mensa.json", "rt") as f:
                return json.load(f)
        except FileNotFoundError:
            return None

    def save_menu_to_cache(self, menu):
        with open("cache/mensa.json", "wt") as f:
            json.dump(menu, f)

    def fetch_menu(self):
        url = self.base_url + "getMenu/sb"
        json_data = fetch_url(url)
        menu = json.loads(json_data)
        # get today's menu
        menu = menu["days"][0]
        menu["source"] = url
        menu["time"] = datetime.now().isoformat()
        return menu
    
        
if (__name__ == "__main__"):
    from pprint import pprint
    mensa = Mensa()
    pprint(mensa.get_menu())

