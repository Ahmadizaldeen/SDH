USE sdh;
SET foreign_key_checks = 0;
LOAD DATA LOCAL INFILE 'csv/personen.csv'
INTO TABLE users
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(@anrede, vorname, nachname, @strasse, @haus_nr, @plz, @stadt, email, user_name, password,@user_id);
SET foreign_key_checks = 1;