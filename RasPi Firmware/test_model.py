import mysql.connector
from mysql.connector import Error
import pandas as pd
import pickle
from datetime import datetime

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
digiaddress = retrieveVar("digiaddress")
city = retrieveVar("city")
sec_code = retrieveVar("sec_code")
now = datetime.now()
formatted_date = now.strftime('%Y-%m-%d')


cursor = connection.cursor()
try:
    cursor.execute(cursor.execute('insert into Meter(Meter_ID, Digitaladdress, City, Date_issued,Security_code,Operational) values(%s, %s, %s, %s, %s, "Yes")', (meter_id,digiaddress,city,formatted_date,sec_code)))
    print("Insertion successful")
except Error as err:
    print(f"Error: '{err}'")
    

def read_data():
    rawData = pd.read_csv('Days28.csv')

    # Setting the target and dropping the unnecessary columns
    y = rawData[['FLAG']]
    X = rawData.drop(['FLAG', 'CONS_NO'], axis=1)
    T28 = X.columns[1005:]
    X = X[T28]

    print('Normal Consumers:                    ', y[y['FLAG'] == 0].count()[0])
    print('Consumers with Fraud:                ', y[y['FLAG'] == 1].count()[0])
    print('Total Consumers:                     ', y.shape[0])
    print("Classification assuming no fraud:     %.2f" % (y[y['FLAG'] == 0].count()[0] / y.shape[0] * 100), "%")

    # columns reindexing according to dates
    X.columns = pd.to_datetime(X.columns)
    X = X.reindex(X.columns, axis=1)


    return X, y

X, y = read_data()


filename = 'finalized_model.sav'
loaded_model = pickle.load(open(filename, 'rb'))
result = loaded_model.predict(X)
rl_db = ""
if result[0] == 1:
    rl_db = "Yes"
elif result[0] == 0:
    rl_db = "No"


try:
    cursor.execute(cursor.execute('update meter set Theft = (%s) where meter_id = (%s)', (rl_db, meter_id)))
    print("Insertion successful")
except Error as err:
    print(f"Error: '{err}'")

connection.commit()
connection.close()

