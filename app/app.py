import json

from flask import Flask, Blueprint, render_template, request
from flask_admin import Admin, expose, BaseView
from flask_admin.menu import MenuLink
from flask_admin.contrib.fileadmin import FileAdmin
from flask_security import SQLAlchemyUserDatastore, Security, current_user
import os.path as osp

from sqlalchemy import exc

import models
from views import PUISStudentActivityModelView, PUISStudentTogaSizeModelView, AdminModelView, \
    ActivityModelView, ProfileView, HomeView, PUISStudentModelView, StudentCardModelView
from views.base_model_view import TOGA_ACTIVITY_ID

app: Flask = Flask(__name__)
app.config.from_pyfile("../config.py")
models.db.init_app(app)

user_datastore: SQLAlchemyUserDatastore = SQLAlchemyUserDatastore(models.db, models.User, models.Roles)
security: Security = Security(app, user_datastore)

ADMIN_USER_ID = 4

# ----------------------
# BEGIN CLIENT BLUEPRINT
# ----------------------

client_blueprint = Blueprint("Client", "Client")


@client_blueprint.route("/")
def home():
    return render_template("client/home.html")


@client_blueprint.route("/choose-toga-size")
def toga_size():
    available_toga_size = models.TogaSize.query.all()
    print(available_toga_size)
    return render_template("client/choose-toga-size.html", available_toga_size=available_toga_size)


@client_blueprint.route("/api/v1/student/<student_id>", methods=["POST"])
def student(student_id):
    return_data = {
        "student_id": student_id,
        "success": False,
        "error": "",
        "data": {},
    }
    json_post = None
    try:
        json_post = json.loads(request.data)
    except json.JSONDecodeError:
        return_data["error"] = "No valid POST JSON data specified"
        return return_data

    student: models.PUISStudent = models.PUISStudent.get_where_student_id(student_id)

    if str(student.date_of_birth) != json_post["dateOfBirth"]:
        return_data["error"] = "Invalid student ID or date of birth"
        return return_data

    if student is not None:
        activity_done_by_student: [models.PUISStudentActivity] = models.PUISStudentActivity.get_where_student_has_id(
            student.id)
        activity_done_by_student_json: [dict] = list(map(lambda o: o.to_dict(), activity_done_by_student))

        return_data["success"] = True
        return_data["data"] = {
            "activities_done": activity_done_by_student_json,
        }
    else:
        return_data["error"] = "Invalid student ID or date of birth"

    return return_data


@client_blueprint.route("/api/v1/student/toga-size/<student_id>", methods=["POST"])
def student_toga_size(student_id):
    return_data = {
        "student_id": student_id,
        "success": False,
        "error": "",
        "data": {},
    }
    json_post = None
    try:
        json_post = json.loads(request.data)
    except json.JSONDecodeError:
        return_data["error"] = "No valid POST JSON data specified"
        return return_data

    student: models.PUISStudent = models.PUISStudent.get_where_student_id(student_id)

    if str(student.date_of_birth) != json_post["dateOfBirth"]:
        return_data["error"] = "Invalid student ID or date of birth"
        return return_data

    if student is not None:
        if not models.PUISStudentActivity.can_user_take_activity(student_id,
                                                                 TOGA_ACTIVITY_ID):
            return_data["error"] = "User must complete the previous activity"
            return return_data

        student_toga_size : models.PUISStudentTogaSize = models.PUISStudentTogaSize()
        student_toga_size.toga_size_id = json_post["togaSize"]
        student_toga_size.puis_student_id = student_id
        models.db.session.add(student_toga_size)
        try:
            models.db.session.commit()
        except exc.SQLAlchemyError as e:
            return_data["error"] = f"Error: {e}"
            return return_data

        puis_student_activity : models.PUISStudentActivity = models.PUISStudentActivity()
        puis_student_activity.puis_student_id = student_id
        puis_student_activity.activity_id = TOGA_ACTIVITY_ID
        puis_student_activity.signed_by_user_id = ADMIN_USER_ID
        puis_student_activity.description = f"Toga with size id {json_post['togaSize']}"
        models.db.session.add(puis_student_activity)
        try:
            models.db.session.commit()
        except exc.SQLAlchemyError as e:
            return_data["error"] = f"Error: {e}"
            return return_data

        return_data["success"] = True
    else:
        return_data["error"] = "Invalid student ID or date of birth"

    return return_data


app.register_blueprint(client_blueprint)


# --------------------
# END CLIENT BLUEPRINT
# --------------------

# ---------------------
# BEGIN ADMIN BLUEPRINT
# ---------------------


class AdminFileAdmin(FileAdmin):
    def is_accessible(self):
        return current_user.is_authenticated and current_user.has_role("admin")


class AuthenticatedMenuLink(MenuLink):
    def is_accessible(self):
        return current_user.is_authenticated


class UnauthenticatedMenuLink(MenuLink):
    def is_accessible(self):
        return not current_user.is_authenticated


admin: Admin = Admin(
    app,
    "Clearance Admin",
    index_view=HomeView()
)

# Students
admin.add_view(PUISStudentModelView(models.PUISStudent, models.db.session, category="Student"))
admin.add_view(PUISStudentActivityModelView(models.PUISStudentActivity, models.db.session, category="Student"))
admin.add_view(StudentCardModelView(models.Card, models.db.session, category="Student"))
admin.add_view(PUISStudentTogaSizeModelView(models.PUISStudentTogaSize, models.db.session, category="Student"))

# Configuration
admin.add_view(ActivityModelView(models.Activity, models.db.session, category="Configuration"))
admin.add_view(AdminModelView(models.ActivityRequirement, models.db.session, category="Configuration"))
admin.add_view(AdminModelView(models.Prodi, models.db.session, category="Configuration"))
admin.add_view(AdminModelView(models.TogaSize, models.db.session, category="Configuration"))
admin.add_view(AdminModelView(models.PUISStudentStatus, models.db.session, category="Configuration"))

# System
admin.add_view(AdminModelView(models.User, models.db.session, category="System"))
admin.add_view(AdminModelView(models.UserProdiConstraint, models.db.session, category="System"))
admin.add_view(AdminModelView(models.Roles, models.db.session, category="System"))
admin.add_view(AdminModelView(models.Department, models.db.session, category="System"))

# Miscellaneous
path = osp.join(osp.dirname(__file__), "upload")
admin.add_view(AdminFileAdmin(path, endpoint="/file/", name="Files", category="Miscellaneous"))

# --
admin.add_view(ProfileView(name="Profile", endpoint="profile"))

admin.add_link(UnauthenticatedMenuLink(name="Login", endpoint="security.login"))
admin.add_link(AuthenticatedMenuLink(name="Logout", endpoint="security.logout"))

# -------------------
# END ADMIN BLUEPRINT
# -------------------

if __name__ == "__main__":
    app.run(debug=True)
