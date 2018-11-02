CREATE TABLE user (
    username VARCHAR PRIMARY KEY,
    password VARCHAR NOT NULL,
    description VARCHAR,
    avatar VARCHAR,
    points INTEGER
);

CREATE TABLE story (
    story_id INTEGER PRIMARY KEY,
    story_title VARCHAR NOT NULL,
    story_text VARCHAR NOT NULL,
    story_date DATETIME NOT NULL,
    story_votes INTEGER NOT NULL,
    username VARCHAR NOT NULL REFERENCES user
);

CREATE TABLE comment (
    cmt_id INTEGER PRIMARY KEY,
    cmt_text VARCHAR NOT NULL,
    cmt_date DATETIME NOT NULL,
    cmt_votes INTEGER NOT NULL, 
    cmt_father INTEGER REFERENCES comment, 
    story_id INTEGER NOT NULL REFERENCES story,
    username VARCHAR NOT NULL REFERENCES user
);

INSERT INTO user values ('mrzephyr17', '1428280996dd70facd24f0dc2a706120bec14420', NULL, NULL, NULL);
INSERT INTO user values ('castro', '85136c79cbf9fe36bb9d05d0639c70c265c18d37', NULL, NULL, NULL);
INSERT INTO user values ('acaciomamao', 'f369e2507256b8598a0b90660ca21b69cc87ed83', NULL, NULL, NULL);

INSERT INTO story values(NULL, 'Porto won!', 'Thank you Eder.', '2018-10-25 10:00:00',10, 'mrzephyr17');
INSERT INTO story values(NULL, 'Daredevil S3 is out!', 'Go check it out!', '2018-10-26 21:08:07',10, 'castro');

INSERT INTO comment values(NULL, 'Casillas is a god.', '2018-10-25 10:05:00',10,NULL, 1,'acaciomamao');
INSERT INTO comment values(NULL, 'Who needs Aboubakar?', '2018-10-25 10:30:00',10,NULL, 1, 'castro');
INSERT INTO comment values(NULL, 'Poindexter is crazy', '2018-10-26 21:51:17', 10,NULL,2, 'mrzephyr17');
INSERT INTO comment values(NULL, 'Murdock and Nelson avocados at law!', '2018-10-26 22:32:41',10,NULL, 2,'acaciomamao');
