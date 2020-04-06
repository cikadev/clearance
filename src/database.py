from mysql.connector import connect
import os


def init():
    database_connection = connect(
        host=os.getenv("DATABASE_HOST"),
        user=os.getenv("DATABASE_USERNAME"),
        password=os.getenv("DATABASE_PASSWORD"),
        database=os.getenv("DATABASE_NAME"),
    )
    return database_connection, database_connection.cursor(dictionary=True)