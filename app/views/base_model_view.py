from flask import request, url_for, redirect, abort
from flask_admin.contrib import sqla
from flask_security import current_user

import models

# TODO
# Circular import
TOGA_ACTIVITY_ID = 4


class BaseModelView(sqla.ModelView):
    create_modal = True
    form_excluded_columns = ("created_at", "updated_at", "signed_by_user")

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
        self.can_delete = current_user.has_role("admin")

    def on_model_change(self, form, model, is_created: bool):
        if isinstance(model, models.PUISStudentActivity):
            if model.activity.id == TOGA_ACTIVITY_ID:
                raise Exception("Please use PUISStudentTogaSize menu")

            if is_created:
                model.signed_by_user_id = current_user.id

            if not models.PUISStudentActivity.can_user_take_activity(model.puis_student.id, model.activity.id):
                raise Exception("User must complete the previous activity")

            if not models.UserProdiConstraint.is_user_has_access_for_prodi(current_user.id, model.puis_student.prodi_id):
                raise Exception("The student you are trying to modify is out of your Prodi scope")

    def on_model_delete(self, model):
        if isinstance(model, models.PUISStudentActivity):
            if model.activity.id == TOGA_ACTIVITY_ID:
                puis_student_activity_toga_size = models.PUISStudentTogaSize.query.filter_by(
                    puis_student_id=model.puis_student.id).first()
                if puis_student_activity_toga_size is not None:
                    models.db.session.delete(puis_student_activity_toga_size)
                    models.db.session.commit()

            if not models.UserProdiConstraint.is_user_has_access_for_prodi(current_user.id, model.puis_student.prodi_id):
                raise Exception("The student you are trying to modify is out of your Prodi scope")
        elif isinstance(model, models.PUISStudentTogaSize):
            puis_student_activity = models.PUISStudentActivity.query.filter_by(
                puis_student_id=model.puis_student.id,
                activity_id=TOGA_ACTIVITY_ID).first()
            if puis_student_activity is not None:
                models.db.session.delete(puis_student_activity)
                models.db.session.commit()

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
