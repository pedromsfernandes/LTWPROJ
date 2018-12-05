<<<<<<< HEAD
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
    -- channel_header VARCHAR,
    channel_creator INTEGER REFERENCES user
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

-- DEFAULTS

INSERT INTO channel VALUES (NULL, 'soccer', 'Discuss soccer.', NULL);
INSERT INTO channel VALUES (NULL, 'movies', 'Discuss movies.', NULL);
INSERT INTO channel VALUES (NULL, 'nba', 'Discuss nba.', NULL);
INSERT INTO channel VALUES (NULL, 'news', 'Discuss news.', NULL);
INSERT INTO channel VALUES (NULL, 'television', 'Discuss television.', NULL);
INSERT INTO channel VALUES (NULL, 'games', 'Discuss games.', NULL);
INSERT INTO channel VALUES (NULL, 'mma', 'Discuss mma.', NULL);

INSERT INTO tag VALUES (NULL, 'help');
INSERT INTO tag VALUES (NULL, 'media');
INSERT INTO tag VALUES (NULL, 'ama');
INSERT INTO tag VALUES (NULL, 'fluff');
INSERT INTO tag VALUES (NULL, 'discussion');
INSERT INTO tag VALUES (NULL, 'question');

-- TESTS

INSERT INTO user VALUES(NULL, 'mrzephyr17', 'asd', NULL, NULL, 0);
INSERT INTO user VALUES(NULL, 'castro', 'asdasd', NULL, NULL, 0);
INSERT INTO user VALUES(NULL, 'acaciomamao', 'asasdasdasdd', NULL, NULL, 0);

INSERT INTO post VALUES(NULL, 'ya', 'O incentivo ao avanço tecnológico, assim como a valorização de fatores subjetivos oferece uma interessante oportunidade para verificação de alternativas às soluções ortodoxas.
', '2018-10-25 10:00:00', 1, NULL, 1);

INSERT INTO post VALUES(NULL, 'ye', 'O cuidado em identificar pontos críticos na mobilidade dos capitais internacionais estende o alcance e a importância das direções preferenciais no sentido do progresso.
', '2018-10-26 21:08:07', 2, NULL, 2);

INSERT INTO post values(NULL, NULL, 'Casillas is a god.', '2018-10-25 10:05:00', 3, 1, NULL);
INSERT INTO post values(NULL, NULL, 'Who needs Aboubakar?', '2018-10-25 10:30:00', 2, 1, NULL);
INSERT INTO post values(NULL, NULL, 'Poindexter is crazy', '2018-10-26 21:51:17', 1, 2, NULL);
INSERT INTO post values(NULL, NULL, 'Murdock and Nelson avocados at law!', '2018-10-26 22:32:41', 3, 2, NULL);

-- TRIGGERS

CREATE TRIGGER AutoSub
AFTER INSERT ON channel
FOR EACH ROW
BEGIN
INSERT INTO subscription VALUES(New.channel_id, New.channel_creator);
END;


CREATE TRIGGER AutoUpvote
AFTER INSERT ON post
FOR EACH ROW
BEGIN
INSERT INTO vote VALUES(New.post_id, New.post_op, 1);
END;


CREATE TRIGGER AddPoint
AFTER INSERT ON vote
FOR EACH ROW
BEGIN
UPDATE user SET user_points = user_points + New.vote WHERE user_id IN (SELECT post_op FROM post WHERE post_id = New.post_id);
END;

CREATE TRIGGER RemPoint1
AFTER DELETE ON vote
FOR EACH ROW
WHEN Old.vote = 1
BEGIN
UPDATE user SET user_points = user_points - 1 WHERE user_id IN (SELECT post_op FROM post WHERE post_id = Old.post_id);
END;

CREATE TRIGGER RemPoint2
AFTER DELETE ON vote
FOR EACH ROW
WHEN Old.vote = -1
BEGIN
UPDATE user SET user_points = user_points + 1 WHERE user_id IN (SELECT post_op FROM post WHERE post_id = Old.post_id);
END;
=======
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
    -- channel_header VARCHAR,
    channel_creator INTEGER REFERENCES user
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

-- DEFAULTS

INSERT INTO channel VALUES (NULL, 'soccer', 'Discuss soccer.', NULL);
INSERT INTO channel VALUES (NULL, 'movies', 'Discuss movies.', NULL);
INSERT INTO channel VALUES (NULL, 'nba', 'Discuss nba.', NULL);
INSERT INTO channel VALUES (NULL, 'news', 'Discuss news.', NULL);
INSERT INTO channel VALUES (NULL, 'television', 'Discuss television.', NULL);
INSERT INTO channel VALUES (NULL, 'games', 'Discuss games.', NULL);
INSERT INTO channel VALUES (NULL, 'mma', 'Discuss mma.', NULL);

INSERT INTO tag VALUES (NULL, 'help');
INSERT INTO tag VALUES (NULL, 'media');
INSERT INTO tag VALUES (NULL, 'ama');
INSERT INTO tag VALUES (NULL, 'fluff');
INSERT INTO tag VALUES (NULL, 'discussion');
INSERT INTO tag VALUES (NULL, 'question');

-- TESTS

INSERT INTO user VALUES(NULL, 'mrzephyr17', 'asd', NULL, NULL, 0);
INSERT INTO user VALUES(NULL, 'castro', 'asdasd', NULL, NULL, 0);
INSERT INTO user VALUES(NULL, 'acaciomamao', 'asasdasdasdd', NULL, NULL, 0);

INSERT INTO post VALUES(NULL, 'ya', 'O incentivo ao avanço tecnológico, assim como a valorização de fatores subjetivos oferece uma interessante oportunidade para verificação de alternativas às soluções ortodoxas.
', '2018-10-25 10:00:00', 1, NULL, 1);

INSERT INTO post VALUES(NULL, 'ye', 'O cuidado em identificar pontos críticos na mobilidade dos capitais internacionais estende o alcance e a importância das direções preferenciais no sentido do progresso.
', '2018-10-26 21:08:07', 2, NULL, 2);

INSERT INTO post values(NULL, NULL, 'Casillas is a god.', '2018-10-25 10:05:00', 3, 1, NULL);
INSERT INTO post values(NULL, NULL, 'Who needs Aboubakar?', '2018-10-25 10:30:00', 2, 1, NULL);
INSERT INTO post values(NULL, NULL, 'Poindexter is crazy', '2018-10-26 21:51:17', 1, 2, NULL);
INSERT INTO post values(NULL, NULL, 'Murdock and Nelson avocados at law!', '2018-10-26 22:32:41', 3, 2, NULL);

-- TRIGGERS

CREATE TRIGGER AutoSub
AFTER INSERT ON channel
FOR EACH ROW
BEGIN
INSERT INTO subscription VALUES(New.channel_id, New.channel_creator);
END;


CREATE TRIGGER AutoUpvote
AFTER INSERT ON post
FOR EACH ROW
BEGIN
INSERT INTO vote VALUES(New.post_id, New.post_op, 1);
END;


CREATE TRIGGER AddPoint
AFTER INSERT ON vote
FOR EACH ROW
BEGIN
UPDATE user SET user_points = user_points + New.vote WHERE user_id IN (SELECT post_op FROM post WHERE post_id = New.post_id);
END;

CREATE TRIGGER RemPoint
AFTER DELETE ON vote
FOR EACH ROW
WHEN Old.vote = 1
BEGIN
UPDATE user SET user_points = user_points - Old.vote WHERE user_id IN (SELECT post_op FROM post WHERE post_id = Old.post_id);
END;
>>>>>>> 3a84a6dcac15dda9c1622021c83f398912f60894
