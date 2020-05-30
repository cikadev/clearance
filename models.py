from datetime import datetime
from flask_security import RoleMixin, UserMixin
from sqlalchemy import Column
from flask_sqlalchemy import SQLAlchemy

db: SQLAlchemy = SQLAlchemy()


class Type(db.Model, RoleMixin):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False, autoincrement=True)
    type: Column = db.Column(db.String(255), unique=True, nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.type

    @property
    def name(self):
        return type


class Department(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    name: Column = db.Column(db.String(255), nullable=False)
    location: Column = db.Column(db.String(255), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.name


class ActivityRequirement(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    activity_id: Column = db.Column(db.Integer, db.ForeignKey("activity.id"), nullable=False)
    depends_on_activity_id: Column = db.Column(db.Integer, db.ForeignKey("activity.id"), nullable=False)
    activity: Column = db.relationship("Activity", foreign_keys=[activity_id],
                                       backref=db.backref("activity_requirement_activity", lazy="dynamic"))
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    depends_on_activity: Column = db.relationship("Activity", foreign_keys=[depends_on_activity_id],
                                                  backref=db.backref("activity_requirement_depends_on_activity",
                                                                     lazy="dynamic"))


class Card(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    card: Column = db.Column(db.String(255), nullable=False)
    puis_student_id: Column = db.Column(db.Integer, db.ForeignKey("puis_student.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    puis_student: Column = db.relationship("PUISStudent", backref=db.backref("puis_student_id", lazy="dynamic"))

    def __str__(self):
        return self.card


class Activity(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    activity: Column = db.Column(db.String(255), nullable=False)
    department_id: Column = db.Column(db.Integer, db.ForeignKey("department.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    department: Column = db.relationship("Department", backref=db.backref("activity_department", lazy="dynamic"))

    def __str__(self):
        return self.activity


class TogaSize(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    toga_size: Column = db.Column(db.String(255), unique=True, nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.toga_size


class PUISStudent(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    name: Column = db.Column(db.String(255), unique=True, nullable=False)
    email: Column = db.Column(db.String(255), unique=True, nullable=False)
    batch: Column = db.Column(db.String(255), unique=True, nullable=False)
    date_of_birth: Column = db.Column(db.DateTime(), unique=True, nullable=False)
    defense_date: Column = db.Column(db.DateTime(), unique=True, nullable=False)
    prodi_id: Column = db.Column(db.Integer, db.ForeignKey("prodi.id"), nullable=False)
    puis_student_status_id: Column = db.Column(db.Integer, db.ForeignKey("puis_student_status.id"), nullable=False)
    toga_size_id: Column = db.Column(db.Integer, db.ForeignKey("toga_size.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    puis_student_status: Column = db.relationship("PUISStudentStatus",
                                                  backref=db.backref("Student Status", lazy="dynamic"))
    prodi: Column = db.relationship("Prodi", backref=db.backref("Student Prodi", lazy="dynamic"))
    toga_size: Column = db.relationship("TogaSize", backref=db.backref("Student Toga Size", lazy="dynamic"))

    def __str__(self):
        return self.name


class PUISStudentActivity(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    puis_student_id: Column = db.Column(db.Integer, db.ForeignKey("puis_student.id"), nullable=False)
    puis_student: Column = db.relationship("PUISStudent", backref=db.backref("Completing Activity", lazy="dynamic"))
    activity_id: Column = db.Column(db.Integer, db.ForeignKey("activity.id"), nullable=False)
    activity: Column = db.relationship("Activity", backref=db.backref("puis_student_activity_activity", lazy="dynamic"))
    signed_by_user_id: Column = db.Column(db.Integer, db.ForeignKey("user.id"), nullable=False)
    signed_by_user: Column = db.relationship("User", backref=db.backref("puis_student_activity_user", lazy="dynamic"))
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return str(self.activity)


class PUISStudentStatus(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    puis_student_status: Column = db.Column(db.String(255), unique=True, nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.puis_student_status


class Prodi(db.Model):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    prodi: Column = db.Column(db.String(255), unique=True, nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    def __str__(self):
        return self.prodi


class User(db.Model, UserMixin):
    id: Column = db.Column(db.Integer(), primary_key=True, nullable=False)
    username: Column = db.Column(db.String(255), unique=True, nullable=False)
    email: Column = db.Column(db.String(255), unique=True, nullable=False)
    password: Column = db.Column(db.String(255), nullable=False)
    department_id: Column = db.Column(db.Integer, db.ForeignKey("department.id"), nullable=False)
    type_id: Column = db.Column(db.Integer, db.ForeignKey("type.id"), nullable=False)
    created_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow)
    updated_at: Column = db.Column(db.DateTime(), nullable=False, default=datetime.utcnow, onupdate=datetime.utcnow)

    department: Column = db.relationship("Department", backref=db.backref("user_department", lazy="dynamic"))
    type: Column = db.relationship("Type", backref=db.backref("user_type", lazy="dynamic"))

    def __str__(self):
        return self.email

    @property
    def is_authenticated(self):
        return True

    @property
    def active(self):
        return True

    @property
    def role(self):
        return str(self.type)
