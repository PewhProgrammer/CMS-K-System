from bus import SaarVV
from mensa import Mensa
from flask import Flask, jsonify


app = Flask(__name__)


mensa = Mensa()
saarvv = SaarVV()


@app.route("/mensa")
def get_mensa():
    return jsonify(mensa.get_menu())

@app.route("/bus")
def get_bus():
    return jsonify(saarvv.get_schedule())

