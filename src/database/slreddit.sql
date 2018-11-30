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
    channel_desc VARCHAR NOT NULL
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

INSERT INTO channel VALUES (NULL, 'soccer', 'Discuss soccer.');
INSERT INTO channel VALUES (NULL, 'movies', 'Discuss movies.');
INSERT INTO channel VALUES (NULL, 'nba', 'Discuss nba.');
INSERT INTO channel VALUES (NULL, 'news', 'Discuss news.');
INSERT INTO channel VALUES (NULL, 'television', 'Discuss television.');
INSERT INTO channel VALUES (NULL, 'games', 'Discuss games.');
INSERT INTO channel VALUES (NULL, 'mma', 'Discuss mma.');

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

INSERT INTO post values(NULL, NULL, 'Casillas is a god.', '2018-10-25 10:05:00',3,1,NULL);
INSERT INTO post values(NULL, NULL,'Who needs Aboubakar?', '2018-10-25 10:30:00',2,1, NULL);
INSERT INTO post values(NULL, NULL,'Poindexter is crazy', '2018-10-26 21:51:17', 1,2,NULL);
INSERT INTO post values(NULL, NULL,'Murdock and Nelson avocados at law!', '2018-10-26 22:32:41',3,2, NULL);