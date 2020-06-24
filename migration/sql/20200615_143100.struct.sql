ALTER TABLE puis_student
    CHANGE `email` `email` varchar(255) COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE puis_student
    CHANGE `date_of_birth` `date_of_birth` date NULL;

ALTER TABLE puis_student
    CHANGE `defense_date` `defense_date` date NULL;
