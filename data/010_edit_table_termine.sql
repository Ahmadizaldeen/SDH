use sdh;
SET foreign_key_checks = 0;

ALTER TABLE termine DROP FOREIGN KEY fk_termin_user;
ALTER TABLE termine DROP FOREIGN KEY fk_termin_fachbereich;
ALTER TABLE termine DROP COLUMN user_id;
ALTER TABLE termine DROP COLUMN fachbereich_id;
ALTER TABLE termine DROP COLUMN datum;
ALTER TABLE termine DROP zeit;
ALTER TABLE termine DROP COLUMN notizen;


ALTER TABLE termine ADD COLUMN beginn DATE;
ALTER TABLE termine ADD COLUMN ende DATE;

ALTER TABLE termine ADD COLUMN seminare_id INT;
ALTER TABLE termine ADD COLUMN raeume_id INT;

SET foreign_key_checks = 1;
