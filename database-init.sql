CREATE DATABASE IF NOT EXISTS `web-project`;

use `web-project`;

create table tests (id MEDIUMINT NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL, PRIMARY KEY (id));
create table questions (id MEDIUMINT NOT NULL AUTO_INCREMENT, question varchar(255) NOT NULL, test_id MEDIUMINT NOT NULL, PRIMARY KEY (id), FOREIGN KEY (test_id) REFERENCES tests(id));
create table answers (id MEDIUMINT NOT NULL AUTO_INCREMENT, answer varchar(255) NOT NULL, is_correct BOOLEAN NOT NULL, question_id MEDIUMINT NOT NULL, PRIMARY KEY (id), FOREIGN KEY (question_id) REFERENCES questions(id));
create table questions_comments (id MEDIUMINT NOT NULL AUTO_INCREMENT, comment_name varchar(255) NOT NULL, comment varchar(255) NOT NULL, question_id MEDIUMINT NOT NULL, PRIMARY KEY (id), FOREIGN KEY (question_id) REFERENCES questions(id));
create table answers_comments (id MEDIUMINT NOT NULL AUTO_INCREMENT, comment_name varchar(255) NOT NULL, comment varchar(255) NOT NULL, answer_id MEDIUMINT NOT NULL, PRIMARY KEY (id), FOREIGN KEY (answer_id) REFERENCES answers(id));