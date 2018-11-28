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