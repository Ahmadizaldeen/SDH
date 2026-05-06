use sdh;
SET foreign_key_checks = 0;
CREATE TABLE users_termine (
    user_id INT UNSIGNED NOT NULL,
    termine_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (user_id, termine_id),

    CONSTRAINT fk_users
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_termine
        FOREIGN KEY (termine_id) REFERENCES termine(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SET foreign_key_checks = 1;

