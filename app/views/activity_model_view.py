from . admin_model_view import AdminModelView

import models


class ActivityModelView(AdminModelView):
    TOGA_ACTIVITY_ID = 4

    form_excluded_columns = AdminModelView.form_excluded_columns + ('activity_record',)

    def on_model_delete(self, model):
        if isinstance(model, models.Activity) and model.id == TOGA_ACTIVITY_ID:
            raise Exception('This activity cannot be removed since it is required in a hardcoded logic.')

