from flask import Flask, request, jsonify
import joblib

app = Flask(__name__)
model = joblib.load("student_model.pkl")

@app.route("/predict", methods=["POST"])
def predict():
    data = request.json

    features = [[
        float(data["study_hours"]),
        float(data["attendance"]),
        float(data["previous_grade"]),
        float(data["assignment_score"])
    ]]

    prediction = model.predict(features)[0]
    probability = model.predict_proba(features)[0][1]

    return jsonify({
        "prediction": int(prediction),
        "probability": float(probability)
    })

if __name__ == "__main__":
    app.run(port=5000)