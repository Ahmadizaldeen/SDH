USE sdh;
SET foreign_key_checks = 0;
LOAD DATA LOCAL INFILE 'csv/studenten_termine.csv'
INTO TABLE users_termine
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(user_id,termine_id);
SET foreign_key_checks = 1;