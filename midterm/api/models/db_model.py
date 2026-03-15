from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy() 

class Prediction(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    age = db.Column(db.Integer)
    sex = db.Column(db.Integer)
    bmi = db.Column(db.Float)
    children = db.Column(db.Integer)
    smoker = db.Column(db.Integer)
    region_northwest = db.Column(db.Integer)
    region_southeast = db.Column(db.Integer)
    region_southwest = db.Column(db.Integer)
    predicted_cost = db.Column(db.Float)