USE sdh;

SET foreign_key_checks = 0;

LOAD DATA LOCAL INFILE 'csv/fachbereiche.csv'
INTO TABLE fachbereiche
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(name);

SET foreign_key_checks = 1;