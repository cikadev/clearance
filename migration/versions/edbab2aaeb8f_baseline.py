"""baseline

Revision ID: edbab2aaeb8f
Revises: 
Create Date: 2020-05-31 18:52:22.712632

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy import orm
from os import path


# revision identifiers, used by Alembic.
revision = 'edbab2aaeb8f'
down_revision = None
branch_labels = None
depends_on = None


def upgrade():
    sql_file = open("./clearance-2020_05_31_18_39_31-dump.sql")

    bind = op.get_bind()
    session = orm.Session(bind=bind)

    session.execute(sql_file.read())

    session.commit()


def downgrade():
    # TODO
    pass
