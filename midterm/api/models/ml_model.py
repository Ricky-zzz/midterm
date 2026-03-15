import pickle
import numpy as np

def load_model(path="../insurance_model.pkl"):
    import os
    base_dir = os.path.dirname(os.path.abspath(__file__))
    parent_dir = os.path.dirname(base_dir)
    model_path = os.path.join(parent_dir, "insurance_model.pkl")
    with open(model_path, "rb") as f:
        model = pickle.load(f)
    return model

def prepare_features(data):
    age = int(data["age"])
    sex = 1 if data["sex"].lower() == "male" else 0
    bmi = float(data["bmi"])
    children = int(data["children"])
    smoker = 1 if data["smoker"].lower() == "yes" else 0

    region = data["region"].lower()
    region_nw = 1 if region == "northwest" else 0
    region_se = 1 if region == "southeast" else 0
    region_sw = 1 if region == "southwest" else 0

    features = np.array([[age, sex, bmi, children, smoker, region_nw, region_se, region_sw]])
    return features