USE sdh;
ALTER TABLE users DROP FOREIGN KEY fk_user_adresse;
ALTER TABLE users DROP COLUMN adresse_id;