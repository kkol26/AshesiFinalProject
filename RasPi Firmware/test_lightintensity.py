import mysql.connector
from mysql.connector import Error
import serial 
ser = serial.Serial('/dev/ttyUSB0')

try:
    connection = mysql.connector.connect(host='192.168.91.39',
                                         database='utility_data',
                                         user='root',
                                         password='',
                                         port=3307)

    if connection.is_connected():
        db_Info = connection.get_server_info()
        print("Connected to MySQL Server version ", db_Info)
        cursor = connection.cursor()
        cursor.execute("select database();")
        record = cursor.fetchone()
        print("You're connected to database: ", record)

except Error as e:
    print("Error while connecting to MySQL", e)


def retrieveVar(variable):
    variable = str(variable)
    ffile=open('imps.txt','r').read()
    ini=ffile.find(variable)+(len(variable)+1)
    rest=ffile[ini:]
    search_enter=rest.find('\n')
    hold=rest[:search_enter]
    real_value = hold.split(' ')[1]

    return real_value

meter_id = retrieveVar("meter_id")

while True:
        readline = ser.readline()
        decoded_bytes = readline.decode("utf-8")

        if("Light Intensity" in decoded_bytes):
            decoded_stuff = decoded_bytes.split(' ')
            l_int = decoded_stuff[-1].split()
            l_int= int(l_int[0])
            print(l_int)
            if(l_int > 85):
                try:
                    cursor.execute(cursor.execute('update meter set Theft = (%s) where meter_id = (%s)', ("Yes", meter_id)))
                    print("Insertion successful")
                except Error as err:
                        print(f"Error: '{err}'")

                connection.commit()

