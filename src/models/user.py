from flask_login import UserMixin, login_user


class User(UserMixin):
    def __init__(self, user_id):
        self.id = user_id

    @staticmethod
    def get(user_id):
        if user_id is None:
            return None

        database_cursor.execute(
            "select count(*) from tbl_user where user_id = %(username)s",
            {
                "username": user_id,
            }
        )
        number_of_user = database_cursor.fetchone()["count(*)"]
        is_user_exists = number_of_user > 0

        if is_user_exists:
            user = User(user_id)
            login_user(user)
            return user
        else:
            return None

    @staticmethod
    def login(user_id, password):
        database_cursor.execute(
            "select count(*) from tbl_user where user_id = %(username)s and user_password = %(password)s",
            {
                "username": user_id,
                "password": password,
            }
        )
        number_of_user = database_cursor.fetchone()["count(*)"]
        is_user_exists = number_of_user > 0

        if is_user_exists:
            user = User(user_id)
            login_user(user)
            return user
        else:
            return None
