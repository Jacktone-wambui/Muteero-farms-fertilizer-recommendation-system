// Libraries for temperature and humidity sensors
#include <DHT.h>

// Pin configuration
#define DHT_PIN A0   
#define MUX_PIN_0 2  
#define MUX_PIN_1 3  
#define MUX_PIN_2 4  
#define MUX_PIN_3 5  

// Sensor objects
DHT dht(DHT_PIN, DHT11); 

// Analog multiplexer channel configuration
const int temperatureChannel = 0;  
const int humidityChannel = 1;     
const int nitrogenChannel = 2;     
const int potassiumChannel = 3;    
const int phosphorousChannel = 4;  
const int moistureChannel = 5;     

void setup() {
  // Initialize serial communication
  Serial.begin(9600);

  // Initialize DHT sensor
  dht.begin();

  // Set multiplexer pins as outputs
  pinMode(MUX_PIN_0, OUTPUT);
  pinMode(MUX_PIN_1, OUTPUT);
  pinMode(MUX_PIN_2, OUTPUT);
  pinMode(MUX_PIN_3, OUTPUT);
}

void loop() {
  // Read temperature
  int temperatureValue = readAnalogValue(temperatureChannel);
  float temperature = convertToTemperature(temperatureValue);

  // Read humidity
  int humidityValue = readAnalogValue(humidityChannel);
  float humidity = convertToHumidity(humidityValue);

  // Read nitrogen level
  int nitrogenValue = readAnalogValue(nitrogenChannel);

  // Read potassium level
  int potassiumValue = readAnalogValue(potassiumChannel);

  // Read phosphorous level
  int phosphorousValue = readAnalogValue(phosphorousChannel);

  // Read moisture
  int moistureValue = readAnalogValue(moistureChannel);
  float moisture = convertToMoisture(moistureValue);

  // Display temperature and humidity
  Serial.print("Temperature: ");
  Serial.print(temperature);
  Serial.print(" °C\t | ");
  Serial.print("Humidity: ");
  Serial.print(humidity);
  Serial.print(" %\t | ");

  // Display nitrogen level
  Serial.print("Nitrogen: ");
  Serial.print(nitrogenValue);
  Serial.print("\t | ");

  // Display potassium level
  Serial.print("Potassium: ");
  Serial.print(potassiumValue);
  Serial.print("\t | ");

  // Display phosphorous level
  Serial.print("Phosphorous: ");
  Serial.print(phosphorousValue);
  Serial.print("\t | ");

  // Display moisture
  Serial.print("Moisture: ");
  Serial.print(moisture);
  Serial.print("%\t | ");

  // Soil moisture conditions based on sensor readings
  if (nitrogenValue > 950) {
    Serial.println("No nitrogen, soil is deficient");
  } else if (nitrogenValue >= 400 && nitrogenValue <= 950) {
    Serial.println("There is some nitrogen, soil is medium");
  } else if (nitrogenValue < 400) {
    Serial.println("Soil is rich in nitrogen");
  }

  if (potassiumValue > 950) {
    Serial.println("No potassium, soil is deficient");
  } else if (potassiumValue >= 400 && potassiumValue <= 950) {
    Serial.println("There is some potassium, soil is medium");
  } else if (potassiumValue < 400) {
    Serial.println("Soil is rich in potassium");
  }

  if (phosphorousValue > 950) {
    Serial.println("No phosphorous, soil is deficient");
  } else if (phosphorousValue >= 400 && phosphorousValue <= 950) {
    Serial.println("There is some phosphorous, soil is medium");
  } else if (phosphorousValue < 400) {
    Serial.println("Soil is rich in phosphorous");
  }

  delay(12000);  // Delay between readings
}

// Read analog value from the selected channel
int readAnalogValue(int channel) {
  // Set multiplexer pins based on the channel
  digitalWrite(MUX_PIN_0, bitRead(channel, 0));
  digitalWrite(MUX_PIN_1, bitRead(channel, 1));
  digitalWrite(MUX_PIN_2, bitRead(channel, 2));
  digitalWrite(MUX_PIN_3, bitRead(channel, 3));

  // Read analog value from the selected channel
  int value = analogRead(DHT_PIN);
  return value;
}

// Convert analog value to temperature in Celsius
float convertToTemperature(int value) {
  float temperature = map(value, 0, 1023, -50, 150);
  return temperature;
}

// Convert analog value to humidity in percentage
float convertToHumidity(int value) {
  float humidity = map(value, 0, 1023, 0, 100);
  return humidity;
}

// Convert analog value to moisture in percentage
float convertToMoisture(int value) {
  float moisture = map(value, 0, 1023, 0, 100);
  return moisture;
}