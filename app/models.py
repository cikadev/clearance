from datetime import datetime
from flask_security import RoleMixin, UserMixin
from sqlalchemy import Column
from flask_sqlalchemy import SQLAlchemy

db: SQLAlchemy = SQLAlchemy()


class Roles(db.Model, RoleMixin):
    id: Column = db.Column(db.Integer(), primary_key=True, autoincrement=True)
    role: Column = db.Column(db.String(255), unique=True, nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.role


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
                                       backref=db.backref("activity_requirement_activity", lazy="dynamic"))
    depends_on_activity: Column = db.relationship("Activity", foreign_keys=[depends_on_activity_id],
                                                  backref=db.backref("activity_requirement_depends_on_activity",
                                                                     lazy="dynamic"))


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

    department: Column = db.relationship("Department", backref=db.backref("activity_department", lazy="dynamic"))

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
    toga_size_id: Column = db.Column(db.Integer, db.ForeignKey("toga_size.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    # FK data
    puis_student_status: Column = db.relationship("PUISStudentStatus",
                                                  backref=db.backref("Student Status", lazy="dynamic"))
    prodi: Column = db.relationship("Prodi", backref=db.backref("Student Prodi", lazy="dynamic"))
    toga_size: Column = db.relationship("TogaSize", backref=db.backref("Student Toga Size", lazy="dynamic"))

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
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    # FK data
    puis_student: Column = db.relationship("PUISStudent", backref=db.backref("Completing Activity", lazy="dynamic"))
    activity: Column = db.relationship("Activity", backref=db.backref("puis_student_activity_activity", lazy="dynamic"))
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

        return PUISStudentActivity.query.filter_by(
            activity_id=activity_requirement.depends_on_activity_id,
            puis_student_id=puis_student_id).first() is not None

    def to_dict(self):
        data = self.__dict__
        del data["_sa_instance_state"]
        for k in ("created_at", "updated_at"):
            data[k] = str(data[k])
        return data


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
    department: Column = db.relationship("Department", backref=db.backref("user_department", lazy="dynamic"))
    role: Column = db.relationship("Roles", backref=db.backref("user_role", lazy="dynamic"))

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
