from . base_model_view import BaseModelView


class StudentCardModelView(BaseModelView):
    column_searchable_list = ("card",)
