from flask_security import current_user
from . base_model_view import BaseModelView


class AdminModelView(BaseModelView):
    def is_has_sufficient_role(self):
        return current_user.has_role("admin")
