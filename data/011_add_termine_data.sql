USE sdh;

SET foreign_key_checks = 0;

LOAD DATA LOCAL INFILE 'csv/termine.csv'
INTO TABLE termine
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(beginn, ende, seminare_id, standort_id, raeume_id);

SET foreign_key_checks = 1;