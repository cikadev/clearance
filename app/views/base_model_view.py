from flask import request, url_for, redirect, abort
from flask_admin.contrib import sqla
from flask_security import current_user

import models


class BaseModelView(sqla.ModelView):
    create_modal = True
    form_excluded_columns = ('created_at', 'updated_at', 'signed_by_user')

    def is_has_sufficient_role(self):
        return True

    def is_accessible(self):
        return current_user.is_authenticated and self.is_has_sufficient_role()

    def _handle_view(self, name, **kwargs):
        if not self.is_accessible():
            if current_user.is_authenticated:
                return redirect(url_for('admin.index'), 403)
            else:
                return redirect(url_for('security.login', next=request.url))
        self.can_delete = current_user.has_role('admin')

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
