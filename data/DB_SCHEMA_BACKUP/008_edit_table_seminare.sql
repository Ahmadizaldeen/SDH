use sdh;
SET foreign_key_checks = 0;
ALTER TABLE seminare DROP FOREIGN KEY fk_seminar_raum;
ALTER TABLE seminare DROP COLUMN raum_id;
ALTER TABLE seminare DROP COLUMN status_id;
ALTER TABLE seminare DROP COLUMN datum;
ALTER TABLE seminare DROP COLUMN start_datum;
ALTER TABLE seminare DROP COLUMN end_datum;
SET foreign_key_checks = 1;