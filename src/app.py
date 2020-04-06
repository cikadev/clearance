from flask import Flask, request
import mysql.connector
import json
from dotenv import load_dotenv
from flask_login import LoginManager, login_required, logout_user, current_user
import os

import src.database as database
from src.models import User

load_dotenv()

database_connection, database_cursor = database.init()

app = Flask(__name__)
app.config["DEBUG"] = True
app.config["SECRET_KEY"] = os.getenv("SECRET_KEY")

# Flask Login
login_manager: LoginManager = LoginManager()
login_manager.init_app(app)


@login_manager.user_loader
def load_user(user_id):
    return User.get(user_id)


@login_manager.unauthorized_handler
def unauthorized():
    return json.dumps({
        "success": False,
        "message": "Not authenticated",
        "data": {},
    }), 403


# Routing
@app.route("/api/v1/login", methods=["POST"])
def login():
    username = request.form.get("username")
    password = request.form.get("password")
    if User.login(username, password) is not None:
        return json.dumps({
            "success": True,
            "message": "",
            "data": {},
        }), 200
    else:
        return json.dumps({
            "success": False,
            "message": "Invalid credential",
            "data": {},
        }), 403


@app.route("/api/v1/logout")
@login_required
def logout():
    logout_user()
    return json.dumps({
        "success": True,
        "message": "",
        "data": {},
    })


@app.route("/api/v1/me")
@login_required
def me():
    return json.dumps({
        "success": True,
        "message": "",
        "data": {
            "id": current_user.id
        },
    })


@app.route('/api/v1/student/completeness', methods=["GET"])
def student_completeness():
    # This SQL logic is fucked up, the table is not in good shape!!!
    database_cursor.execute("select count(*) from tbl_cs where cs_status = 'Checked'")
    result_for_checked = database_cursor.fetchone()

    database_cursor.execute("select count(*) from tbl_cs where cs_status = 'Uncheck'")
    result_for_uncheck = database_cursor.fetchone()
  
    return json.dumps({
        "success": True,
        "message": "",
        "data": {
            "checked": result_for_checked["count(*)"],
            "uncheck": result_for_uncheck["count(*)"],
        },
    })

  
@app.route('/api/v1/student', methods=["GET"])
def api_student():
    database_cursor.execute("select * from puis_student")
    students = database_cursor.fetchall()

    student_list = []
    for student in students:
        student_list.append({
            "success": True,
            "message": "",
            "data": {
                "name": student["std_name"],
                "email": student["std_email"],
                "batch": student["std_batch"],
                "major": student["std_prodi"],
                "bod": student["std_bod"],
                "status": student["std_status"],
            }
        })

    return json.dumps(student_list)


@app.route("/api/v1/department", methods=["GET", "POST"])
@login_required
def api_department():
    if request.method == "POST":
        database_cursor.execute("insert into tbl_dep (dep_name, place) values (%(name)s, %(place)s)", {
            "name": request.form.get("name"),
            "place": request.form.get("place"),
        })
        database_connection.commit()

        database_cursor.execute("select * FROM tbl_dep WHERE dep_id = %(dept_id)s", {
            "dept_id": database_cursor.lastrowid,
        })
        department = database_cursor.fetchone()

        return json.dumps({
            "success": True,
            "message": "",
            "data": {
                "id": department["dep_id"],
                "name": department["dep_name"],
                "place": department["place"]
            }
        })
    elif request.method == "GET":
        database_cursor.execute("select dep_id, dep_name, place from tbl_dep")
        departments = database_cursor.fetchall()

        departments_list = []
        for department in departments:
            departments_list.append({
                "id": department["dep_id"],
                "name": department["dep_name"],
                "place": department["place"],
            })

        return json.dumps({
            "success": True,
            "message": "",
            "data": {
                "departments": departments_list,
            }
        })


@app.route('/api/v1/staff', methods=['POST'])
def staff():
    department_user_working_on = request.form.get("department")

    database_cursor.execute("insert into tbl_user (user_id, user_name, user_email, user_password, dep_id, user_type)\
        values (%(id)s , %(name)s, %(email)s, %(password)s, %(department)s, 'staff')", {
        "id": request.form.get('id'),
        "name": request.form.get('name'),
        "email": request.form.get('email'),
        "password": request.form.get('password'),
        "department": department_user_working_on,
    })
    database_connection.commit()

    database_cursor.execute("select * from tbl_user where user_id = %(id)s and dep_id = $(dep)", {
        "id": database_cursor.lastrowid,
        "department": department_user_working_on
    })
    user = database_cursor.fetchone()

    return json.dumps({
        "success": True,
        "message": "",
        "data": {
            "id": user["user_id"],
            "name": user["user_name"],
            "email": user["user_email"],
            "user_type": user["user_type"],
            "department_id": user["dep_id"],
        }
    })


if __name__ == "__main__":
    app.run()
