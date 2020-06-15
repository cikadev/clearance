from . base_model_view import BaseModelView
from . activity_model_view import ActivityModelView

from flask_security import current_user

import models


class PUISStudentActivityModelView(BaseModelView):
    form_create_rules = ('puis_student', 'activity', 'description')
    form_args = {
        'activity': {
            'query_factory': lambda: models.Activity.query if current_user.has_role('admin') else \
            models.db.session.query(models.Activity).filter(
                models.Activity.department == current_user.department
            ),
        },
    }

    def on_model_change(self, form, model, is_created: bool):
        assert(isinstance(model, models.PUISStudentActivity))

        if is_created:
            model.signed_by_user_id = current_user.id

        if model.activity.id == ActivityModelView.TOGA_ACTIVITY_ID:
            raise Exception("Please use PUISStudentTogaSize menu")
        elif model.activity.department.id != current_user.department.id and not current_user.has_role('admin'):
            raise Exception("You are not allowed to create or modify this activity: insufficient role.")
        elif not models.PUISStudentActivity.can_user_take_activity(model.puis_student.id, model.activity.id):
            raise Exception("User must complete the previous activity")

    def on_model_delete(self, model):
        assert (isinstance(model, models.PUISStudentActivity))
        if model.activity.id == ActivityModelView.TOGA_ACTIVITY_ID:
            puis_student_activity_toga_size = models.PUISStudentTogaSize.query.filter_by(
                puis_student_id=model.puis_student.id).first()
            if puis_student_activity_toga_size is not None:
                models.db.session.delete(puis_student_activity_toga_size)
                models.db.session.commit()
