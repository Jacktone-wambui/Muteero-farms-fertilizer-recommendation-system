from flask import Flask, request, jsonify, render_template
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import LabelEncoder
import joblib

app = Flask(__name__)

# Load the data
data = pd.read_csv('Fertilizer Prediction.csv')

# Convert categorical columns to numerical using Label Encoding
le = LabelEncoder()
data['Soil Type'] = le.fit_transform(data['Soil Type'])
data['Crop Type'] = le.fit_transform(data['Crop Type'])
data['Nitrogen'] = le.fit_transform(data['Nitrogen'])
data['Potassium'] = le.fit_transform(data['Potassium'])
data['Phosphorous'] = le.fit_transform(data['Phosphorous'])
data['Moisture'] = le.fit_transform(data['Moisture'])
data['Temparature'] = le.fit_transform(data['Temparature'])
data['Fertilizer Name'] = le.fit_transform(data['Fertilizer Name'])

# Separate features and target variable
X = data.drop('Fertilizer Name', axis=1)
y = data['Fertilizer Name']

# Initialize the Random Forest classifier
clf = RandomForestClassifier(n_estimators=100, random_state=42)

# Train the classifier
clf.fit(X, y)

# Save the trained model
joblib.dump(clf, 'fertilizer_model.pkl')

@app.route('/')
def index():
    return render_template('index1.html')

@app.route('/predict', methods=['POST'])
def predict():
    # Load the model
    model = joblib.load('fertilizer_model.pkl')

    # Get data from the request
    data = request.get_json(force=True)

    # Preprocess the input data
    data['Soil Type'] = le.transform(data['Soil Type'])
    data['Crop Type'] = le.transform(data['Crop Type'])
    data['Nitrogen'] = le.transform(data['Nitrogen'])
    data['Potassium'] = le.transform(data['Potassium'])
    data['Phosphorous'] = le.transform(data['Phosphorous'])
    data['Moisture'] = le.transform(data['Moisture'])
    data['Temparature'] = le.transform(data['Temparature'])
        

    # Convert data to array format for prediction
    input_data = [[data['Temperature'],data['Moisture'], data['Soil Type'], data['Crop Type'], data['Nitrogen'], data['Potassium'], data['Phosphorous']]]

    # Make prediction using the loaded model
    prediction = model.predict(input_data)

    # Convert prediction to fertilizer name using inverse transform
    predicted_fertilizer = le.inverse_transform(prediction)
    
    # Return the predicted fertilizer
    return jsonify({'Fertilizer Name': predicted_fertilizer[0]})

if __name__ == '__main__':
    app.run(debug=True)
