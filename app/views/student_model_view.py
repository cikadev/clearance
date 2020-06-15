from . admin_model_view import AdminModelView


class PUISStudentModelView(AdminModelView):
    form_excluded_columns = AdminModelView.form_excluded_columns + (
        'completing_activity', 'puis_student_id', 'puis_student'
    )
    column_searchable_list = ("student_id", "name")
