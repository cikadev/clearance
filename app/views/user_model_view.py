from . admin_model_view import AdminModelView


class UserModelView(AdminModelView):
    column_exclude_list = ('password',)
    form_excluded_columns = AdminModelView.form_excluded_columns + ('puis_student_activity_user',)
