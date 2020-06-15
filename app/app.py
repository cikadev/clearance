import json

from flask import Flask, Blueprint, render_template
from flask_admin import Admin, expose, BaseView
from flask_admin.menu import MenuLink
from flask_admin.contrib.fileadmin import FileAdmin
from flask_security import SQLAlchemyUserDatastore, Security, current_user
import os.path as osp

import models
from views import *

app: Flask = Flask(__name__)
app.config.from_pyfile("../config.py")
models.db.init_app(app)

user_datastore: SQLAlchemyUserDatastore = SQLAlchemyUserDatastore(models.db, models.User, models.Roles)
security: Security = Security(app, user_datastore)

# ----------------------
# BEGIN CLIENT BLUEPRINT
# ----------------------


client_blueprint = Blueprint("Client", "Client")


@client_blueprint.route("/")
def index():
    return render_template("client/home.html")


@client_blueprint.route("/api/v1/student/<student_id>")
def student(student_id):
    student: models.PUISStudent = models.PUISStudent.get_where_student_id(student_id)
    success: bool = False
    error_msg: str = "No user found"
    data: dict = {}

    if student is not None:
        success = True
        error_msg = ""
        activity_done_by_student: [models.PUISStudentActivity] = models.PUISStudentActivity.get_where_student_has_id(
            student.id)
        activity_done_by_student_json: [dict] = list(map(lambda o: o.to_dict(), activity_done_by_student))
        data = {
            "activities_done": activity_done_by_student_json,
        }

    return json.dumps({
        "student_id": student_id,
        "success": success,
        "error": error_msg,
        "data": data,
    })


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
admin.add_view(CardModelView(models.Card, models.db.session, category="Student"))
admin.add_view(PUISStudentTogaSizeModelView(models.PUISStudentTogaSize, models.db.session, category="Student"))

# Configuration
admin.add_view(ActivityModelView(models.Activity, models.db.session, category="Configuration"))
admin.add_view(AdminModelView(models.ActivityRequirement, models.db.session, category="Configuration"))
admin.add_view(AdminModelView(models.Prodi, models.db.session, category="Configuration"))
admin.add_view(AdminModelView(models.TogaSize, models.db.session, category="Configuration"))
admin.add_view(AdminModelView(models.PUISStudentStatus, models.db.session, category="Configuration"))

# System
admin.add_view(UserModelView(models.User, models.db.session, category="System"))
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
