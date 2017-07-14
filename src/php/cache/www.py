from urllib.request import Request, urlopen
from io import TextIOWrapper

def fetch_url(url, encoding = "utf-8"):
    #print(url)
    req = Request(
        url = url,
        data = None, 
        headers = {
            "User-Agent": "Mozilla/5.0 (X11; Linux x86_64; rv:51.0) Gecko/20100101 Firefox/51.0"
        }
    )
    with urlopen(req) as f:
        return f.read().decode(encoding)
