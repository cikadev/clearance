from datetime import datetime
from flask_security import RoleMixin, UserMixin
from sqlalchemy import Column
from flask_sqlalchemy import SQLAlchemy

db: SQLAlchemy = SQLAlchemy()


class Roles(db.Model, RoleMixin):
    id: Column = db.Column(db.Integer(), primary_key=True, autoincrement=True)
    name: Column = db.Column(db.String(255), unique=True, nullable=False)
    # description: Column = db.Column(db.String(255))
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.name


class Department(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    name: Column = db.Column(db.String(255), nullable=False)
    location: Column = db.Column(db.String(255), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.name


class ActivityRequirement(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    activity_id: Column = db.Column(db.Integer, db.ForeignKey("activity.id"), nullable=False)
    depends_on_activity_id: Column = db.Column(db.Integer, db.ForeignKey("activity.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    # FK data
    activity: Column = db.relationship("Activity", foreign_keys=[activity_id],
                                       backref=db.backref("Activities depending on this activity", lazy="dynamic"))
    depends_on_activity: Column = db.relationship("Activity", foreign_keys=[depends_on_activity_id],
                                                  backref=db.backref("Depends on activities",
                                                                     lazy="dynamic"))

    def __str__(self):
        return str(self.activity)


class Card(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    card: Column = db.Column(db.String(255), unique=True, nullable=False)
    puis_student_id: Column = db.Column(db.Integer, db.ForeignKey("puis_student.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    puis_student: Column = db.relationship("PUISStudent", backref=db.backref("puis_student_id", lazy="dynamic"))

    def __str__(self):
        return self.card


class Activity(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    activity: Column = db.Column(db.String(255), nullable=False)
    department_id: Column = db.Column(db.Integer, db.ForeignKey("department.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    department: Column = db.relationship("Department", backref=db.backref("activities_with_department", lazy="dynamic"))

    def __str__(self):
        return self.activity


class TogaSize(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    size_name: Column = db.Column(db.String(255), unique=True, nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.size_name


class PUISStudent(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    student_id: Column = db.Column(db.String(255), unique=True, nullable=False)
    name: Column = db.Column(db.String(255), nullable=False)
    email: Column = db.Column(db.String(255), nullable=False)
    batch: Column = db.Column(db.String(255), nullable=False)
    date_of_birth: Column = db.Column(db.Date(), nullable=False)
    defense_date: Column = db.Column(db.Date(), nullable=False)
    prodi_id: Column = db.Column(db.Integer, db.ForeignKey("prodi.id"), nullable=False)
    puis_student_status_id: Column = db.Column(db.Integer, db.ForeignKey("puis_student_status.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    # FK data
    puis_student_status: Column = db.relationship("PUISStudentStatus",
                                                  backref=db.backref("Student Status", lazy="dynamic"))
    prodi: Column = db.relationship("Prodi", backref=db.backref("Student Prodi", lazy="dynamic"))

    def __str__(self):
        return f"{self.student_id} {self.name}"

    @staticmethod
    def get_where_student_id(student_id):
        return PUISStudent.query.filter_by(student_id=student_id).first()


class PUISStudentActivity(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    puis_student_id: Column = db.Column(db.Integer, db.ForeignKey("puis_student.id"), nullable=False)
    activity_id: Column = db.Column(db.Integer, db.ForeignKey("activity.id"), nullable=False)
    signed_by_user_id: Column = db.Column(db.Integer, db.ForeignKey("user.id"), nullable=False)
    description: Column = db.Column(db.Text, nullable=True)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    # FK data
    puis_student: Column = db.relationship("PUISStudent", backref=db.backref("Completing Activity", lazy="dynamic"))
    activity: Column = db.relationship("Activity")
    signed_by_user: Column = db.relationship("User", backref=db.backref("puis_student_activity_user", lazy="dynamic"))

    def __str__(self):
        return str(self.activity)

    @staticmethod
    def get_where_student_has_id(id):
        return PUISStudentActivity.query.filter_by(puis_student_id=id).all()

    @staticmethod
    def can_user_take_activity(puis_student_id, activity_id):
        activity_requirement: ActivityRequirement = ActivityRequirement.query.filter_by(activity_id=activity_id).first()
        if activity_requirement is None:
            return True

        return PUISStudentActivity.where_student_id_and_activity_id_is(
            puis_student_id, activity_requirement.depends_on_activity_id
        ) is not None

    @staticmethod
    def where_student_id_and_activity_id_is(student_id, activity_id):
        return PUISStudentActivity.query.filter_by(
            activity_id=activity_id,
            puis_student_id=student_id).first()

    def to_dict(self):
        data = self.__dict__
        for k in ("created_at", "updated_at"):
            data[k] = str(data[k])

        data["activity"] = self.activity.__dict__
        for k in ("created_at", "updated_at"):
            data["activity"][k] = str(data["activity"][k])

        if "_sa_instance_state" in data["activity"]:
            del data["activity"]["_sa_instance_state"]
        if "_sa_instance_state" in data:
            del data["_sa_instance_state"]

        return data


class PUISStudentTogaSize(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    puis_student_id: Column = db.Column(db.Integer, db.ForeignKey("puis_student.id"), unique=True, nullable=False)
    toga_size_id: Column = db.Column(db.Integer, db.ForeignKey("toga_size.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    # FK data
    puis_student: Column = db.relationship("PUISStudent", backref=db.backref("PUIS Student", lazy="dynamic"))
    toga_size: Column = db.relationship("TogaSize", backref=db.backref("Toga Size", lazy="dynamic"))


class PUISStudentStatus(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    status: Column = db.Column(db.String(255), unique=True, nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.status


class Prodi(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True)
    name: Column = db.Column(db.String(255), unique=True, nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.name


class User(db.Model, UserMixin):
    id: Column = db.Column(db.Integer(), primary_key=True)
    username: Column = db.Column(db.String(255), unique=True, nullable=False)
    email: Column = db.Column(db.String(255), unique=True, nullable=False)
    password: Column = db.Column(db.String(255), nullable=False)
    department_id: Column = db.Column(db.Integer, db.ForeignKey("department.id"), nullable=False)
    roles_id: Column = db.Column(db.Integer, db.ForeignKey("roles.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    # FK data
    department: Column = db.relationship("Department", backref=db.backref("user_with_department", lazy="dynamic"))
    role: Column = db.relationship("Roles", backref=db.backref("users_with_role", lazy="dynamic"))

    def __str__(self):
        return self.email

    @property
    def is_authenticated(self):
        return True

    @property
    def active(self):
        return True

    def has_role(self, role):
        return role in str(self.role)

    @staticmethod
    def get_where_user_id(user_id):
        return User.query.filter_by(id=user_id).first()
