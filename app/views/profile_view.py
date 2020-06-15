from flask import request
from flask_admin import expose, BaseView
from flask_security import current_user

import models


class ProfileView(BaseView):
    @expose("/", methods=['GET', 'POST'])
    def change_password(self):
        if request.method == "POST":
            if request.form["new_password"] == request.form["confirm_password"]:
                current_user.password = request.form["confirm_password"]
                models.db.session.commit()
        return self.render("admin/profile.html", user=current_user)

    def is_has_sufficient_role(self):
        return True

    def is_accessible(self):
        return current_user.is_authenticated and self.is_has_sufficient_role()
