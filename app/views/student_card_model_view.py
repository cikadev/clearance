from . base_model_view import BaseModelView


class CardModelView(BaseModelView):
    column_searchable_list = ("card",)
