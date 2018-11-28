CREATE TABLE IF NOT EXISTS user (
    user_id INTEGER PRIMARY KEY, 
    user_name VARCHAR NOT NULL,
    user_pass VARCHAR NOT NULL,
    user_description VARCHAR,
    user_avatar VARCHAR,
    user_points INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS subscription (
    channel_id INTEGER REFERENCES channel,
    user_id INTEGER REFERENCES user,
    PRIMARY KEY (channel_id, user_id)
);

CREATE TABLE IF NOT EXISTS post (
    post_id INTEGER PRIMARY KEY,
    post_title VARCHAR,
    post_text VARCHAR NOT NULL,
    post_date DATETIME NOT NULL,
    post_op INTEGER NOT NULL REFERENCES user,
    post_father INTEGER REFERENCES post,
    channel_id INTEGER REFERENCES channel
);

CREATE TABLE IF NOT EXISTS post_tag (
    post_id INTEGER REFERENCES post,
    tag_id INTEGER REFERENCES tag,
    PRIMARY KEY (post_id, tag_id)
);

CREATE TABLE IF NOT EXISTS channel (
    channel_id INTEGER PRIMARY KEY,
    channel_name VARCHAR NOT NULL,
    channel_desc VARCHAR NOT NULL,
    user_id INTEGER NOT NULL REFERENCES user
);

CREATE TABLE IF NOT EXISTS vote (
    post_id INTEGER NOT NULL REFERENCES post,
    user_id INTEGER NOT NULL REFERENCES user,
    vote INTEGER NOT NULL,
    PRIMARY KEY (post_id, user_id)
);

CREATE TABLE IF NOT EXISTS tag (
    tag_id INTEGER PRIMARY KEY,
    tag_text VARCHAR NOT NULL
);

INSERT INTO user values (NULL, 'mrzephyr17', '1428280996dd70facd24f0dc2a706120bec14420', NULL, NULL, 0);
INSERT INTO user values (NULL, 'castro', '85136c79cbf9fe36bb9d05d0639c70c265c18d37', NULL, NULL, 0);
INSERT INTO user values (NULL, 'acaciomamao', 'f369e2507256b8598a0b90660ca21b69cc87ed83', NULL, NULL, 0);

INSERT INTO post values(NULL, 'Porto won!', 'Thank you Eder.', '2018-10-25 10:00:00', 1, NULL, 1);
INSERT INTO post values(NULL, 'Daredevil S3 is out!', 'Go check it out!', '2018-10-26 21:08:07', 2, NULL, 2);

INSERT INTO channel values(NULL, 'soccer', 'Discuss football.', 1);
INSERT INTO channel values(NULL, 'television', 'Discuss television.', 1);

INSERT INTO post values(NULL, NULL, 'Casillas is a god.', '2018-10-25 10:05:00',3,1, NULL);
INSERT INTO post values(NULL, NULL, 'Who needs Aboubakar?', '2018-10-25 10:30:00',2,1, NULL);
INSERT INTO post values(NULL, NULL, 'Poindexter is crazy', '2018-10-26 21:51:17', 1,2, NULL);
INSERT INTO post values(NULL, NULL, 'Murdock and Nelson avocados at law!', '2018-10-26 22:32:41',3,2, NULL);
