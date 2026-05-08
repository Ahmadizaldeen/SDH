USE sdh;

SET foreign_key_checks = 0;

LOAD DATA LOCAL INFILE 'csv/seminare.csv'
INTO TABLE seminare
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(title, beschreibung, preis, fachbereich_id);

SET foreign_key_checks = 1;