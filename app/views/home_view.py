from flask import request
from flask_admin import expose, AdminIndexView

from sqlalchemy.sql import text
import models


class HomeView(AdminIndexView):
    @expose('/', methods=['GET'])
    def index(self):
        student_idnumber = request.args.get('student_idnumber')
        record_list = None

        if student_idnumber:
            stmt = text(
                'SELECT activity.activity name, t.created_at completed_at\n'
                'FROM activity\n'
                '   LEFT JOIN (\n'
                '       SELECT activity_id, created_at\n'
                '       FROM puis_student_activity\n'
                '           WHERE puis_student_id = (SELECT id FROM puis_student WHERE student_id = :student_id)\n'
                '   ) t ON activity.id = t.activity_id'
            ).bindparams(student_id=student_idnumber)
            record_list = models.db.session.execute(stmt).fetchall()
        else:
            student_idnumber = ''

        return self.render('admin/index.html', student_idnumber=student_idnumber, record_list=record_list)
