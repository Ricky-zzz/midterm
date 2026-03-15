import pandas as pd
from sklearn.linear_model import LogisticRegression
import joblib

# Sample dataset
data = {
    "study_hours": [1,2,3,4,5,6,7,8,2,3,5,6],
    "attendance": [50,60,65,70,80,85,90,95,55,68,78,88],
    "previous_grade": [60,65,70,75,85,90,92,96,58,72,80,89],
    "assignment_score": [55,60,68,72,82,88,91,94,52,70,79,90],
    "result": [0,0,0,0,1,1,1,1,0,0,1,1]
}

df = pd.DataFrame(data)

X = df[["study_hours","attendance","previous_grade","assignment_score"]]
y = df["result"]

model = LogisticRegression()
model.fit(X, y)

joblib.dump(model, "student_model.pkl")