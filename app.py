import models

from flask import Flask, request, url_for, redirect, abort
from flask_admin import Admin, expose, BaseView
from flask_security import SQLAlchemyUserDatastore, Security, current_user
from flask_admin.contrib import sqla

app: Flask = Flask(__name__)
app.config.from_pyfile("config.py")

models.db.init_app(app)

user_datastore: SQLAlchemyUserDatastore = SQLAlchemyUserDatastore(models.db, models.User, models.Type)
security: Security = Security(app, user_datastore)


class BaseModelView(sqla.ModelView):
    create_modal = True
    form_widget_args = {
        'created_at': {
            'readonly': True,
        },
        'updated_at': {
            'readonly': True,
        },
        'signed_by_user': {
            'readonly': True,
        }
    }
    form_excluded_columns = ("created_at", "updated_at")

    def is_has_sufficient_role(self):
        return True

    def is_accessible(self):
        return current_user.is_authenticated and self.is_has_sufficient_role()

    def _handle_view(self, name, **kwargs):
        if not self.is_accessible():
            if current_user.is_authenticated:
                abort(403)
            else:
                return redirect(url_for("security.login", next=request.url))
        self.can_delete = current_user.role.lower() == "admin"

    # def create_form(self, obj=None):
    #     form = super().create_form(obj)
    #     if self.model is PUISStudentActivity:
    #         signed_by_user_id = request.args.get("signed_by_user_id")
    #         print(">>>"+str(signed_by_user_id))
    #         if signed_by_user_id and not form.signed_by_user_id.data:
    #             form.signed_by_user_id.data = current_user.id
    #     return form

    # def get_query(self):
    #     if self.model is User:
    #         return self.session.query(self.model).filter(self.model.username == "admin")
    #     else:
    #         return super().get_query()


class AdminModelView(BaseModelView):
    def is_has_sufficient_role(self):
        return current_user.role.lower() == "admin"


class GeneralModelView(BaseModelView):
    pass


class ProfileView(BaseView):
    @expose("/")
    def index(self):
        return self.render("profile.html")


admin: Admin = Admin(
    app,
    "Clearance Admin"
)

admin.add_view(AdminModelView(models.User, models.db.session))
admin.add_view(AdminModelView(models.Type, models.db.session))
admin.add_view(AdminModelView(models.Department, models.db.session))
admin.add_view(AdminModelView(models.Activity, models.db.session))
admin.add_view(AdminModelView(models.ActivityRequirement, models.db.session))
admin.add_view(AdminModelView(models.Prodi, models.db.session))
admin.add_view(GeneralModelView(models.Card, models.db.session))
admin.add_view(AdminModelView(models.PUISStudent, models.db.session))
admin.add_view(GeneralModelView(models.PUISStudentActivity, models.db.session))
admin.add_view(AdminModelView(models.PUISStudentStatus, models.db.session))
admin.add_view(AdminModelView(models.TogaSize, models.db.session))

admin.add_view(ProfileView(name="Profile", endpoint="profile"))

if __name__ == "__main__":
    app.run(debug=True)
