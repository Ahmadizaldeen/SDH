USE sdh;
ALTER TABLE adresse DROP FOREIGN KEY fk_adresse_land;
ALTER TABLE adresse DROP COLUMN land_id;
DROP TABLE laender;