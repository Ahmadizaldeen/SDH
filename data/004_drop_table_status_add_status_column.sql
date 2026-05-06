USE sdh;

ALTER TABLE nachrichten DROP INDEX fk_nachricht_status;

ALTER TABLE seminare DROP FOREIGN KEY fk_seminar_status;

DROP TABLE status;

ALTER TABLE seminare 
ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'neu';

ALTER TABLE nachrichten 
ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'neu';