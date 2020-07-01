from flask_security import current_user
from .base_model_view import BaseModelView

import models

# TODO
# Circular import
TOGA_ACTIVITY_ID = 4


class PUISStudentTogaSizeModelView(BaseModelView):
    def on_model_change(self, form, model, is_created: bool):
        super().on_model_change(form, model, is_created)

        if isinstance(model, models.PUISStudentTogaSize):
            if is_created:
                if not models.PUISStudentActivity.can_user_take_activity(model.puis_student.id,
                                                                         TOGA_ACTIVITY_ID):
                    raise Exception("User must complete the previous activity")

                puis_student_activity = models.PUISStudentActivity()
                puis_student_activity.puis_student_id = model.puis_student.id
                puis_student_activity.activity_id = TOGA_ACTIVITY_ID
                puis_student_activity.signed_by_user_id = current_user.id
                puis_student_activity.description = f"Toga with size {model.toga_size.size_name}"
                models.db.session.add(puis_student_activity)
                models.db.session.commit()
            else:
                puis_student_activity = models.PUISStudentActivity.where_student_id_and_activity_id_is(
                    model.puis_student.id, TOGA_ACTIVITY_ID)
                puis_student_activity.puis_student_id = model.puis_student.id
                puis_student_activity.signed_by_user_id = current_user.id
                puis_student_activity.description = f"Toga with size {model.toga_size.size_name}"
                models.db.session.add(puis_student_activity)
                models.db.session.commit()
