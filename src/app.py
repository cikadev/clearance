from flask import Flask, request
import mysql.connector
from mysql.connector import errorcode
import json
from dotenv import load_dotenv
import os

load_dotenv()
    

database_connection = mysql.connector.connect(
    host = os.getenv("DATABASE_HOST"),
    user = os.getenv("DATABASE_USERNAME"),
    password = os.getenv("DATABASE_PASSWORD"),
    database= os.getenv("DATABASE_NAME")
)
database_cursor = database_connection.cursor()

app = Flask(__name__)
app.config["DEBUG"] = True

@app.route('/api/v1/login', methods=['POST'])
def login():

    data_for_login = {
        'username' : request.args.get('username')
    }

    query_for_login = "select user_id, user_password, user_type from puacs.tbl_user \
    where user_id = %(username)s"
    
    database_cursor.execute(query_for_login, data_for_login)
    
    result = database_cursor.fetchall()
    if result[0][1] == request.args.get('password'):
        return "200 — Success login"
    else:
        return "403 — Invalid credential"
  
@app.route('/api/v1/student/completeness', methods=['GET'])
def student_completeness():

    data_for_student_completeness = {
        'checked' : "Checked",
        'uncheck' : "Uncheck"
    }

    query_for_count_checked = "select count(cs_status) from tbl_cs \
    where cs_status = %(checked)s"
    query_for_count_uncheck = "select count(cs_status) from tbl_cs \
    where cs_status = %(uncheck)s"

    database_cursor.execute(query_for_count_checked, data_for_student_completeness)
    result_for_checked = database_cursor.fetchall()

    database_cursor.execute(query_for_count_uncheck, data_for_student_completeness)
    result_for_uncheck = database_cursor.fetchall()

    result_in_list = []
    json_formatting = {
        "Checked" : result_for_checked[0][0],
        "Uncheck" : result_for_uncheck[0][0]
    }
    
    result_in_list.append(json_formatting) 
  
    return json.dumps(result_in_list)

  
@app.route('/api/v1/student', methods=['GET'])
def student():
    query_for_showing_student = "select std_name, std_email, std_batch, std_prodi from puis_student"

    database_cursor.execute(query_for_showing_student)

    result = database_cursor.fetchall()
    result_in_list = []
    for data in result:
        json_formatting = {
            "name" : data[0],
            "email" : data[1],
            "batch" : data[2],
            "major" : data[3]
        }
        result_in_list.append(json_formatting)

    return json.dumps(result_in_list)

@app.route('/api/v1/department', methods=['POST', 'GET'])
def department():

    data_for_dept = {
        "name" : request.args.get('name'),
        "place" : request.args.get('place')
    }

    if request.method == "POST":
        query_for_create_dept = "insert into tbl_dep (dep_name, place) \
        values (%(name)s, %(place)s)"

        database_cursor.execute(query_for_create_dept, data_for_dept)

        data_for_dept.update({"dept_id" : database_cursor.lastrowid})

        database_connection.commit()

        query_for_check_dept = "select dep_id, dep_name, place from tbl_dep \
        where dep_id = %(dept_id)s"

        database_cursor.execute(query_for_check_dept, data_for_dept)

        result = database_cursor.fetchall()
        result_in_list = []
        for data in result:
            json_formatting = {
                "id" : data[0],
                "name" : data[1],
                "place" : data[2]
            }
            result_in_list.append(json_formatting)
    
        return json.dumps(result_in_list)

    elif request.method == "GET":
        query_for_checking = "select dep_id, dep_name, place from tbl_dep"

        database_cursor.execute(query_for_checking)

        result = database_cursor.fetchall()

        result_in_list = []
        for data in result:
            json_formatting = {
                "id" : data[0],
                "name" : data[1],
                "place" : data[2]
            }
            result_in_list.append(json_formatting)

        return json.dumps(result_in_list)

@app.route('/api/v1/staff', methods=['POST'])
def staff():

    data_for_staff = {
        "id" : request.args.get('id'),
        "name" : request.args.get('name'),
        "email" : request.args.get('email'),
        "password" : request.args.get('password'),
        "department" : request.args.get('department')
    }

    query_for_creating_staff = "insert into tbl_user (user_id, user_name, user_email, \
    user_password, dep_id, user_type) values (%(id)s , %(name)s, %(email)s, %(password)s, \
    %(department)s, 'staff')"

    database_cursor.execute(query_for_creating_staff, data_for_staff)

    database_connection.commit()

    query_for_check = "SELECT tbl_user.user_id, tbl_user.user_name, tbl_dep.dep_name \
    from tbl_user, tbl_dep where tbl_user.user_id = %(id)s \
    and tbl_user.dep_id = tbl_dep.dep_id"

    database_cursor.execute(query_for_check, data_for_staff)

    result = database_cursor.fetchall()
    result_in_list = []
    for data in result:
        json_formatting = {
            "id" : data[0],
            "name" : data[1],
            "place" : data[2]
        }
        result_in_list.append(json_formatting)
    
    return json.dumps(result_in_list)

app.run()