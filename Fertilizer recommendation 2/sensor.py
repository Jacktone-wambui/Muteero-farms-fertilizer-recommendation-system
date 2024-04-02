from flask import Flask, render_template, request, jsonify
import pickle
from flask_mysqldb import MySQL

app = Flask(__name__)

model = pickle.load(open('classifier.pkl','rb'))
ferti = pickle.load(open('fertilizer.pkl','rb'))

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        data = request.data.decode('utf-8')  
        temperature, humidity, moisture, sodium, potassium, nitrogen = data.split(',')

        # Store the received sensor data in the sensor_data dictionary
        sensor_data['temperature'] = temperature
        sensor_data['humidity'] = humidity
        sensor_data['moisture'] = moisture
        sensor_data['sodium'] = sodium
        sensor_data['potassium'] = potassium
        sensor_data['nitrogen'] = nitrogen

        return jsonify({'message': 'Data received successfully'}), 200
    else:
         return render_template('sensor.html')

app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'fertilizerrecommendation'
mysql = MySQL(app)

@app.route('/store_sensor_data', methods=['POST'])
def store_sensor_data():
    data = request.json
    try:
        cursor = mysql.connection.cursor()
        query = "INSERT INTO sensor_data (temperature, humidity, moisture, sodium, potassium, nitrogen) VALUES (%s, %s, %s, %s, %s, %s)"
        cursor.execute(query, (data['temperature'], data['humidity'], data['moisture'], data['sodium'], data['potassium'], data['nitrogen']))
        mysql.connection.commit()
        cursor.close()
        return jsonify({'message': 'Data stored successfully'}), 200
    except Exception as e:
        return jsonify({'error': str(e)}), 500

sensor_data = {
    'temperature': None,
    'humidity': None,
    'moisture': None,
    'sodium': None,
    'potassium': None,
    'nitrogen': None,
    'predicted_fertilizer': None 
}

# Define the route for updating the sensor data
@app.route('/update-sensor-data', methods=['POST'])
def update_sensor_data():
    data = request.get_json()
    for key in sensor_data:
        sensor_data[key] = data[key]
    return jsonify({'success': True})

# Define the route for the prediction
@app.route('/predict-fertilizer', methods=['POST'])
def predict_fertilizer():
    crop_type = request.form['crop']
    soil_type = request.form['soil']

    # Perform the fertilizer prediction based on crop_type, soil_type, and sensor_data
    # Replace this with your own prediction logic
    predicted_fertilizer = predict_fertilizer_function(crop_type, soil_type, sensor_data)

    # Update the predicted_fertilizer value in the sensor_data dictionary
    sensor_data['predicted_fertilizer'] = predicted_fertilizer

    return jsonify({'fertilizer': predicted_fertilizer})

@app.route('/predict')
def predict():
    return render_template('predict.html')

if __name__ == '__main__':
    app.run(port=8080)