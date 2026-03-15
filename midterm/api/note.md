# 1. Navigate to the extracted folder
cd c:\laragon\www\insurance

# 2. Create a fresh venv
python -m venv venv

# 3. Activate it
.\venv\Scripts\Activate.ps1

# 4. Install dependencies
pip install flask flask-cors flask-sqlalchemy scikit-learn pandas

# 5. Run Flask
cd midterm\api
python app.py