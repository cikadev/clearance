import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="hardwin27",
  passwd="1412"
)

mycursor = mydb.cursor()

mycursor.execute("select * from puacs.tbl_user")

for x in mycursor:
  print(x)