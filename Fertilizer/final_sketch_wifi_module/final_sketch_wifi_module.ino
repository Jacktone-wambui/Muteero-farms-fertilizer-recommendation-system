#include <SoftwareSerial.h>
#include <DHT.h>

#define DHTPIN 1
#define DHTTYPE DHT11

SoftwareSerial esp8266(2, 3);
const char* ssid = "Mufa$a";
const char* password = "Alphabay999!";

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(115200);
  esp8266.begin(9600);
  dht.begin();

  Serial.println("Connecting...");
  
  // Connect to WiFi network
  sendCommand("AT+RST\r\n", 5000);
  sendCommand("AT\r\n", 2000);
  sendCommand("AT+CWMODE=1\r\n", 2000);
  sendCommand("AT+UART_DEF=9600,8,1,0,0\r\n", 2000);
  String connectCommand = "AT+CWJAP=\"" + String(ssid) + "\",\"" + String(password) + "\"\r\n";
  sendCommand(connectCommand, 5000);

  Serial.println("Connected");
}

void loop() {
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();
  float moisture = readMoisture();
  float sodium = readSodium();
  float potassium = readPotassium();
  float nitrogen = readNitrogen();

  Serial.print("Temperature: ");
  Serial.print(temperature);
  Serial.println(" °C");

  Serial.print("Humidity: ");
  Serial.print(humidity);
  Serial.println("%");

  Serial.print("Moisture: ");
  Serial.print(moisture);
  Serial.println("%");

  Serial.print("Sodium: ");
  Serial.print(sodium);
  Serial.println(" ppm");

  Serial.print("Potassium: ");
  Serial.print(potassium);
  Serial.println(" ppm");

  Serial.print("Nitrogen: ");
  Serial.print(nitrogen);
  Serial.println(" ppm");

  String data = String(temperature) + "," + String(humidity) + "," + String(moisture) + "," + String(sodium) + "," + String(potassium) + "," + String(nitrogen);
  sendToFlask(data);

  delay(5000);
}

void sendCommand(String command, const int timeout) {
  esp8266.print(command);

  long int time = millis();
  bool found = false;
  while ((time + timeout) > millis()) {
    while (esp8266.available()) {
      String line = esp8266.readStringUntil('\n');
      if (line.indexOf("OK") >= 0) {
        found = true;
      }
      Serial.print(line);
    }

    if (found) {
      break;
    }
  }
}

void sendToFlask(String data) {
  String command = "AT+CIPSTART=\"TCP\",\"127.0.0.1\",5000\r\n";
  sendCommand(command, 2000);

  command = "AT+CIPSEND=" + String(data.length() + 2) + "\r\n";
  sendCommand(command, 2000);

  esp8266.println(data);
  esp8266.println();

  sendCommand("AT+CIPCLOSE\r\n", 2000);
}

float readMoisture() {
  int sensorValue = analogRead(A0);
  float moisture = map(sensorValue, 0, 1023, 0, 100);
  return moisture;
}

float readSodium() {
  int sensorValue = analogRead(A0);
  float sodium = map(sensorValue, 0, 1023, 0, 1000);
  return sodium;
}

float readPotassium() {
  int sensorValue = analogRead(A0);
  float potassium = map(sensorValue, 0, 1023, 0, 1000);
  return potassium;
}

float readNitrogen() {
  int sensorValue = analogRead(A0);
  float nitrogen = map(sensorValue, 0, 1023, 0, 1000);
  return nitrogen;
}