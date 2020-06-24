from flask_security import current_user
from . base_model_view import BaseModelView
from . activity_model_view import ActivityModelView

import models


class PUISStudentTogaSizeModelView(BaseModelView):
    def is_has_sufficient_role(self):
        return models.Activity.query.filter_by(id=ActivityModelView.TOGA_ACTIVITY_ID).first().department == current_user.department or current_user.has_role('admin')

    def on_model_change(self, form, model, is_created: bool):
        assert(isinstance(model, models.PUISStudentTogaSize))
        if is_created:
            if not models.PUISStudentActivity.can_user_take_activity(model.puis_student.id, ActivityModelView.TOGA_ACTIVITY_ID):
                raise Exception("User must complete the previous activity")
            elif models.Activity.query.filter_by(id=ActivityModelView.TOGA_ACTIVITY_ID).first().department != current_user.department and not current_user.has_role('admin'):
                raise Exception("You are not allowed to create or modify this activity: insufficient role.")

            puis_student_activity = models.PUISStudentActivity()
            puis_student_activity.puis_student_id = model.puis_student.id
            puis_student_activity.activity_id = ActivityModelView.TOGA_ACTIVITY_ID
            puis_student_activity.signed_by_user_id = current_user.id
            puis_student_activity.description = f"Toga with size {model.toga_size.size_name}"

            models.db.session.add(puis_student_activity)
            models.db.session.commit()
        else:
            puis_student_activity = models.PUISStudentActivity.where_student_id_and_activity_id_is(
                model.puis_student.id, ActivityModelView.TOGA_ACTIVITY_ID)
            puis_student_activity.puis_student_id = model.puis_student.id
            puis_student_activity.signed_by_user_id = current_user.id
            puis_student_activity.description = f"Toga with size {model.toga_size.size_name}"

            models.db.session.add(puis_student_activity)
            models.db.session.commit()

    def on_model_delete(self, model):
        assert(isinstance(model, models.PUISStudentTogaSize))
        puis_student_activity = models.PUISStudentActivity.query.filter_by(
            puis_student_id=model.puis_student.id,
            activity_id=ActivityModelView.TOGA_ACTIVITY_ID).first()
        if puis_student_activity is not None:
            models.db.session.delete(puis_student_activity)
            models.db.session.commit()
