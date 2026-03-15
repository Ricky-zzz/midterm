from flask import Flask, request, jsonify
from flask_cors import CORS
from models.db_model import db, Prediction
from models.ml_model import load_model, prepare_features

app = Flask(__name__)
CORS(app)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///predictions.db'
db.init_app(app)

with app.app_context():
    db.create_all()  # create table if not exists

# Load ML model once
ml_model = load_model()

@app.route("/api/predict", methods=["POST"])
def predict():
    data = request.json
    features = prepare_features(data)
    prediction_value = ml_model.predict(features)[0]

    new_pred = Prediction(
        age=int(data["age"]),
        sex=1 if data["sex"].lower() == "male" else 0,
        bmi=float(data["bmi"]),
        children=int(data["children"]),
        smoker=1 if data["smoker"].lower() == "yes" else 0,
        region_northwest=1 if data["region"].lower() == "northwest" else 0,
        region_southeast=1 if data["region"].lower() == "southeast" else 0,
        region_southwest=1 if data["region"].lower() == "southwest" else 0,
        predicted_cost=float(prediction_value)
    )
    db.session.add(new_pred)
    db.session.commit()

    return jsonify({"prediction": float(prediction_value)})

@app.route("/api/index", methods=["GET"])
def get_predictions():
    predictions = Prediction.query.all()
    result = []
    for pred in predictions:
        result.append({
            "id": pred.id,
            "age": pred.age,
            "sex": "Male" if pred.sex == 1 else "Female",
            "bmi": pred.bmi,
            "children": pred.children,
            "smoker": "Yes" if pred.smoker == 1 else "No",
            "region": get_region(pred),
            "predicted_cost": pred.predicted_cost
        })
    return jsonify(result)

def get_region(pred):
    if pred.region_northwest == 1:
        return "Northwest"
    elif pred.region_southeast == 1:
        return "Southeast"
    elif pred.region_southwest == 1:
        return "Southwest"
    else:
        return "Northeast"

if __name__ == "__main__":
    app.run(debug=True)