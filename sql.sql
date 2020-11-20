DROP TABLE IF EXISTS `lesson_participation`, `normative_test`, `normative`, `lesson`,`student_data`,`student`, `group`, `specialization`, `administrator`, `request`, `professor`, `person`;

DROP TABLE IF EXISTS person;
CREATE TABLE person
(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NULL,
    surname VARCHAR(50) NULL,
    patronymic VARCHAR(50) NULL,
    photo MEDIUMBLOB NULL,
    login VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    email VARCHAR(50) NULL,
    role INT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS professor;
CREATE TABLE professor
(
	id INT NOT NULL AUTO_INCREMENT,
    id_person INT NOT NULL,
    job VARCHAR(50) NULL,
    status TINYINT(1) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_person) REFERENCES person(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS request;
CREATE TABLE request
(
    id INT NOT NULL AUTO_INCREMENT,
    id_professor INT NOT NULL,
    certificate MEDIUMBLOB NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_professor) REFERENCES professor(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS administrator;
CREATE TABLE administrator
(
    id INT NOT NULL AUTO_INCREMENT,
	id_person INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_person) REFERENCES person(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS specialization;
CREATE TABLE specialization
(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group`
(
    id INT NOT NULL AUTO_INCREMENT,
    id_professor INT NOT NULL,
    id_specialization INT NOT NULL,
    FOREIGN KEY (id_professor) REFERENCES professor(id) ON DELETE CASCADE,
    FOREIGN KEY (id_specialization) REFERENCES specialization(id) ON DELETE CASCADE,
    name VARCHAR(50) NOT NULL,
    code_word VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS student;
CREATE TABLE student
(
	id INT NOT NULL AUTO_INCREMENT,
    id_person INT NOT NULL,
    birth_date DATE NULL,
    id_group INT NULL,
    group_study VARCHAR(10) NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_person) REFERENCES person(id) ON DELETE CASCADE,
    FOREIGN KEY (id_group) REFERENCES `group`(id) ON DELETE SET NULL
);


DROP TABLE IF EXISTS student_data;
CREATE TABLE student_data
(
    id INT NOT NULL AUTO_INCREMENT,
    id_student INT NOT NULL,
    FOREIGN KEY (id_student) REFERENCES student(id) ON DELETE CASCADE,
    `date` DATETIME NULL,
    weight INT NULL,
    height INT NULL,
    quetelet INT NULL,
    orthostatic INT NULL,
    ruffier FLOAT NULL,
    stange INT NULL,
    tapping_test VARCHAR(50) NULL,
    complaints VARCHAR(50) NULL,
    state_of_health VARCHAR(50) NULL,
    mood VARCHAR(50) NULL,
    sleep VARCHAR(50) NULL,
    appetite VARCHAR(50) NULL,
    efficiency VARCHAR(50) NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS lesson;
CREATE TABLE lesson
(
    id INT NOT NULL AUTO_INCREMENT,
    id_group INT NOT NULL,
    checked TINYINT(1) NOT NULL,
    FOREIGN KEY (id_group) REFERENCES `group`(id) ON DELETE CASCADE,
    `date` DATE NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS normative;
CREATE TABLE normative
(
    id INT NOT NULL AUTO_INCREMENT,
    id_lesson INT NOT NULL,
    FOREIGN KEY (id_lesson) REFERENCES `lesson`(id) ON DELETE CASCADE,
    `text` TEXT NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS normative_test;
CREATE TABLE normative_test
(
    id INT NOT NULL AUTO_INCREMENT,
    id_normative INT NOT NULL,
    FOREIGN KEY (id_normative) REFERENCES normative(id) ON DELETE CASCADE,
    id_student INT NOT NULL,
    FOREIGN KEY (id_student) REFERENCES student(id) ON DELETE CASCADE,
    score INT NULL,
    grade INT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS lesson_participation;
CREATE TABLE lesson_participation
(
    id INT NOT NULL AUTO_INCREMENT,
    id_student INT NOT NULL,
    FOREIGN KEY (id_student) REFERENCES student(id) ON DELETE CASCADE,
    id_lesson INT NOT NULL,
    FOREIGN KEY (id_lesson) REFERENCES lesson(id) ON DELETE CASCADE,
    time_overall INT NULL,
    time_warmup INT NULL,
    time_main INT NULL,
    time_final INT NULL,
    pulse_before_warmup INT NULL,
    pulse_after_warmup INT NULL,
    pulse_after_main INT NULL,
    pulse_after_final INT NULL,
    pulse_after_rest INT NULL,
    tracker_link TEXT NULL,
    distance INT NULL,
    status INT NOT NULL,
    PRIMARY KEY (id)
);

