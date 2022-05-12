 
// Christian ID: 36352022 and Kofi Appiah

#include <Arduino.h>
#include <analogWrite.h>
#include "ACS712.h"
#define SECOND 1000

const int LDR = A0;
// We have 30 amps version sensor connected to A1 pin of arduino
// Replace with your version if necessary



ACS712 sensor(ACS712_30A, 34);
float volt_from_sensor;
float volt_from_other;
int current_sensor_reads = 1;
int power_sensor_reads =1;


// value when light shown on the ;ldr is too high( max ) is 0 
// value when max darkeness is shown on the ldr is 4095 . 

const int LIGHT_THRESHOLD = 153;
unsigned long current_time=0;
unsigned long last_check = 0;
int outputValue = 0;        
 
int  lightIntensity = 0; 
int counter = 0;
float average_current = 0;
float average_power = 0;


// value when light shown on the ;ldr is too high( max ) is 0 
// value when max darkeness is shown on the ldr is 4095 .  

void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600);
  sensor.calibrate();
}

void loop() {
  // put your main code here, to run repeatedly:
  
  LDR_current_sensor();

}

void LDR_current_sensor(){

  delay(2000);
  current_time=millis();
   
    if (current_time - last_check >= SECOND ) {
        
        last_check = current_time;

        lightIntensity  = analogRead(LDR);
         //Serial.println("Lightinyernsity value before maaping  is " + String(lightIntensity));
        outputValue =map(lightIntensity,460,4300, 0,255);  // recalibrating the values 
        //Serial.println("The output value is " + String(outputValue));

        if (isnan(outputValue)) {
            Serial.println(F("Failed to read from ldr  sensor!"));
        return;
        }

        if (outputValue > LIGHT_THRESHOLD) {
          Serial.println(F("someone opened the box/device"));
          }
         else {
            Serial.println(String("Light Intensity = ") + outputValue);
            delay(100);
         }


              
        // Read current sensor  default
        float voltage = 230;
        float current = sensor.getCurrentAC() - 0.14;
        float power = voltage * current;

  
         // Check if any reads failed and exit early and try again.
        if (isnan(current) ) {
            Serial.println(F("Failed to read from acs sensor!"));
        return;
        }


         if ( counter < 9) {
             average_current =  average_current + (current/current_sensor_reads);
             average_power =  average_power + (power/current_sensor_reads);
           
            Serial.println( "number " + String(current_sensor_reads));
            Serial.println(String("I = ") + average_current + " A");
            Serial.println(String("P = ") + average_power + " W");
  
            
          }
   
 
 //increment sensor reads
        current_sensor_reads ++; 

        // increase counter

         counter ++ ; 

       if ( counter  == 9){

  Serial.println("Total  Average current value is  "+ String(average_current ));
  Serial.println("Total  Average power value is  "+ String(average_power ));
  
 current_sensor_reads = 1; 
 average_current= 0; 
 average_power= 0;
  counter =0;
      
     }
    }          
}
