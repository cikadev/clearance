from flask import Flask
from flask import request
import mysql.connector
from mysql.connector import errorcode
import json
from dotenv import load_dotenv
import os

load_dotenv()



mydb = mysql.connector.connect(
  host = os.getenv("DATABASE_HOST"),
  user = os.getenv("DATABASE_USERNAME"),
  password = os.getenv("DATABASE_PASSWORD"),
  database= os.getenv("DATABASE_NAME")
)
mycursor = mydb.cursor()

app = Flask(__name__)
app.config["DEBUG"] = True

@app.route('/login', methods=['POST'])
def login():
  query = "select user_id, user_password, user_type from puacs.tbl_user where user_id = '" + request.args.get('username') + "'"
  
  mycursor.execute(query)
  
  result = mycursor.fetchall()
  if result[0][1] == request.args.get('password'):
    return "200 — Success login"
  else:
    return "403 — Invalid credential"
  
@app.route('/student/completeness', methods=['GET'])
def student_completeness():
  queryForChecked = "select count(cs_status) from tbl_cs where cs_status = 'Checked'"
  queryForUncheck = "select count(cs_status) from tbl_cs where cs_status = 'Uncheck'"
  
  mycursor.execute(queryForChecked)
  resultForChecked = mycursor.fetchall()
  
  mycursor.execute(queryForUncheck)
  resultForUncheck = mycursor.fetchall()

  resultList = []
  temp = {
    "Checked" : resultForChecked[0][0],
    "Uncheck" : resultForUncheck[0][0]
  }
  resultList.append(temp)

  return json.dumps(resultList)

  
@app.route('/student', methods=['GET'])
def student():
  query = "select std_name, std_email, std_batch, std_prodi from puis_student"

  mycursor.execute(query)

  result = mycursor.fetchall()
  resultList = []
  for data in result:
    temp = {
      "name" : data[0],
      "email" : data[1],
      "batch" : data[2],
      "major" : data[3]
    }
    resultList.append(temp)
  
  return json.dumps(resultList)

@app.route('/department', methods=['POST', 'GET'])
def department():
  if request.method == "POST":
    queryForCreate = "insert into tbl_dep (dep_name, place) values ('" + request.args.get('name') + "', '" + request.args.get('place') + "')"
    
    mycursor.execute(queryForCreate)

    mydb.commit()

    queryForChecking = "select dep_id, dep_name, place from tbl_dep where dep_name = '" + request.args.get('name') + "' and place = '" + request.args.get('place') + "'"

    mycursor.execute(queryForChecking)

    result = mycursor.fetchall()
    resultList = []
    for data in result:
      temp = {
        "id" : data[0],
        "name" : data[1],
        "place" : data[2]
      }
      resultList.append(temp)
    
    return json.dumps(resultList)

  elif request.method == "GET":
    queryForChecking = "select dep_id, dep_name, place from tbl_dep"

    mycursor.execute(queryForChecking)

    result = mycursor.fetchall()

    resultList = []
    for data in result:
      temp = {
        "id" : data[0],
        "name" : data[1],
        "place" : data[2]
      }
      resultList.append(temp)
    
    return json.dumps(resultList)

@app.route('/staff', methods=['POST'])
def staff():
  queryForCreate = "insert into tbl_user (user_id, user_name, user_email, user_password, dep_id, user_type)\
 values ('" + request.args.get('id') + "', '" + request.args.get('name') + "', '" + request.args.get('email') + "', '"\
+ request.args.get('password') + "', " + request.args.get('department') + ", 'staff')"

  mycursor.execute(queryForCreate)

  mydb.commit()

  queryForCheck = "SELECT tbl_user.user_id, tbl_user.user_name, tbl_dep.dep_name from tbl_user, tbl_dep\
 where tbl_user.user_id = '" + request.args.get('id') + "' and tbl_user.dep_id = tbl_dep.dep_id"

  mycursor.execute(queryForCheck)

  result = mycursor.fetchall()
  resultList = []
  for data in result:
    temp = {
      "id" : data[0],
      "name" : data[1],
      "place" : data[2]
    }
    resultList.append(temp)
  
  return json.dumps(resultList)

app.run()