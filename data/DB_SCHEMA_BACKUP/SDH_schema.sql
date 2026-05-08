-- ============================================================
-- EDV-Schule: 01_schema.sql
-- Datenbank-Schema basierend auf UML-Diagramm
-- Autor: SDH EDV-Schule Projekt
-- Datum: 30.04.2026
-- ============================================================
CREATE DATABASE IF NOT EXISTS sdh;
USE sdh;
SET FOREIGN_KEY_CHECKS = 0;
-- STRICT_TRANS_TABLES (Verhindert falsche Input, Regelen Großgeschrieben)
-- NO_ENGINE_SUBSTITUTION (bleibt bei InnoDB als Engine, sicher für FOREIGN_KEYS)
SET sql_mode = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION';

-- ------------------------------------------------------------
-- Tabelle: laender
-- Speichert alle Länder (z.B. Deutschland, Österreich)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS laender (
	-- INT UNSIGNED bestimmt den Wert Raum
    id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(20) NOT NULL UNIQUE,
    vorwahl  INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: adresse
-- Gemeinsame Adressdaten für users und Standorte
-- Migration Script 002_ add user_id
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS adresse (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    strasse    VARCHAR(50) NOT NULL,
    haus_nr    VARCHAR(10) NOT NULL,
    plz        VARCHAR(10) NOT NULL,
    stadt      VARCHAR(50) NOT NULL,
    land_id    INT UNSIGNED NULL ,
    CONSTRAINT fk_adresse_land
        FOREIGN KEY (land_id) REFERENCES laender(id)
		-- Orphan Records einschränken
        ON DELETE RESTRICT -- blokiert das Löschen von laender(id) wenn land_id in andere Tabelle eingesetzt
		ON UPDATE CASCADE -- wenn laender(id) sich ändert, wird land_id sich automtic anpassen
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: status
-- Status-Werte (z.B. aktiv, inaktiv, abgeschlossen,...) für users und Seminare, nachrichten
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS status (
    id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(15) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: fachbereiche
-- Fachbereiche / Abteilungen der Schule
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS fachbereiche (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(512)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: standorte
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS standorte (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(20) NOT NULL,
    adresse_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_standort_adresse
        FOREIGN KEY (adresse_id) REFERENCES adresse(id)
        ON DELETE RESTRICT
		ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: raeume
-- Räume an einem Standort
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS raeume (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(10) NOT NULL,
    standort_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_raum_standort
        FOREIGN KEY (standort_id) REFERENCES standorte(id)
        ON DELETE RESTRICT
		ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: seminar klein Gruppe zum lernen
-- Seminare der Schule mit Min./Max.-Teilnehmeranzahl
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS seminare (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(50) NOT NULL,
    raum_id       INT UNSIGNED NOT NULL,
    datum         DATE NOT NULL,
    status_id     INT UNSIGNED NOT NULL,
    fachbereich_id INT UNSIGNED NOT NULL,
    beschreibung  VARCHAR(512),
    start_datum     DATE,
	end_datum		DATE,
    -- Aktulle Anzahl aus der Tabelle anmeldungen : COUNT(user_id) WHERE seminar_id
    min_teilnehmer INT UNSIGNED DEFAULT 6,
	max_teilnehmer INT UNSIGNED DEFAULT 10,
    bild          VARCHAR(256),
    preis         DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    CONSTRAINT fk_seminar_raum
        FOREIGN KEY (raum_id) REFERENCES raeume(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
		
    CONSTRAINT fk_seminar_status
        FOREIGN KEY (status_id) REFERENCES status(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
		
    CONSTRAINT fk_seminar_fachbereich
        FOREIGN KEY (fachbereich_id) REFERENCES fachbereiche(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
		
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vorname       VARCHAR(50) NOT NULL,
    nachname      VARCHAR(50) NOT NULL,
    email         VARCHAR(100) NOT NULL UNIQUE,
    phone         VARCHAR(20),
    gbd           DATE,
    password      VARCHAR(256) NOT NULL,
    adresse_id    INT UNSIGNED NULL, -- User kann komplett ohne Adresse existieren
    user_name     VARCHAR(50) NOT NULL UNIQUE,
    alias         VARCHAR(50),
    erstellt_am   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_adresse
        FOREIGN KEY (adresse_id) REFERENCES adresse(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: termine
-- Termine für Users (mit Standort, Raum, Fachbereich) 1:1 Termin , n termine : 1 user
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS termine (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    datum          DATE NOT NULL,
    zeit           TIME NOT NULL,
    standort_id    INT UNSIGNED NOT NULL,
    notizen        TEXT,
    dauer          DECIMAL(4,2) NOT NULL DEFAULT 1.00,
    fachbereich_id INT UNSIGNED NOT NULL,
    user_id        INT UNSIGNED NOT NULL,
    CONSTRAINT fk_termin_standort
        FOREIGN KEY (standort_id) REFERENCES standorte(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_termin_fachbereich
        FOREIGN KEY (fachbereich_id) REFERENCES fachbereiche(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_termin_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: anmeldungen
-- Verknüpft User mit Seminare (Many-to-Many) 
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS anmeldungen (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id       INT UNSIGNED NOT NULL,
    seminar_id    INT UNSIGNED NOT NULL,
    angemeldet_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	
    -- Verhindert doppelte Anmeldungen
    UNIQUE KEY uq_user_seminar (user_id, seminar_id),
    CONSTRAINT fk_anm_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_anm_seminar
        FOREIGN KEY (seminar_id) REFERENCES seminare(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabelle: nachrichten
-- Kontaktformular-Nachrichten (für Users benutzbar)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS nachrichten (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    begriff    VARCHAR(100) NOT NULL,
    inhalt     VARCHAR(1024) NOT NULL,
    zeit_stmp  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_id  INT UNSIGNED NOT NULL,
    CONSTRAINT fk_nachricht_absender
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_nachricht_status
        FOREIGN KEY (status_id) REFERENCES status(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;