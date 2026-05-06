30.04.2026
- Erstellen das Use-Case Diagramm.
- Akteur definieren , Attribute zuweissen (Gast, user, Admin)
- Daten Struktur Design : Attribute aus die Use-Cases in Tabellen zuordnen + Normalizirung
- UML-Klassen Diagramm vollständigen (Assoziation,Kardinalität)
- SQL-Schema auf profissional-Nivue schreiben

02-05
Nutzung von header(wann kann ich msg in register seite zeigen und wann in mein seite)
base_url.php : einheitliche verbendung und URLs
chk_session : simple prüft gestarte Session, und start es wenn nötig
msg.php : massage händler , über Session gesteuert
validation.php : handleRegisterRequest()- XSS schütz, RegEx Regelen , Controll-Managment,
                 Session Data, Redirect
navigation.php : simple (register.php,start.php)
register.php : HTML form als Template
start.php : als Test gedacht,  msg zeiger, Objekt Erstellen, Debugs, Insert steruern 
Person.php : private Attribute, setter, getter, Active Record, Insert_Update_delete,
             automatische Einsetung von user_name, id, noch nicht vollständigen ,
             aber alle impliementere Funktionen sind Fähig.
Erfolg : Anmeldung über Register Formular, input validation, Error-done/massages in Session,
        Verbindung zu DB, CURD Funktionen, Klasse Person mit Logischem Funktionen (erstellung UNI user_name pro person),

Misserfolg: Person Klasse viel Großer als gedacht(viele offnen Funktionen), validation Ablauf nicht vorab geplant(dadurch stand große Aufwand),
            DB CURD Funktionen sind nicht einheitlich (viele Wiederholung in Code noch zu erwarten)
            Fehler aus PDO nicht betrachtet

04-05 
Person.php : $id zuweissen auf DB, $person beim instziieren in db speichern (insert Method in der Constracter aufrufen)
db_conn.php : um bauen in Funktion zweck debug -> $db als PDO return oder false (gab Problem mit require , $db manschnal undefient) 
funktion/register.php :auf Register Form ruft handleRegisterRequest() -> validation und clean,
                 Set Session Person_date und gibt es als parameter an Person.klass -> Objekt instanieren(automatisch in DB speichern),
                 funktion setUserName() genieriert user_name anhand die vor/nachname _ id -> header
Template/login : simple
pages/login : $db = db() aus db_conn, $user = login($db) aus /Funktion/login
add Funktionen/login.php : POST_validiern und cleanen, prepare stmt (email OR user_name)
                         fetch Userdate (SELECT *) password verifizieren, Login_Data in Session speichern
Template/logout : logout simple form mit bestätigung
funktion/logout : abmeldung und Session löschen
pages/home.php : noch leer , für Debug und msg

Misserfolg:   msg Vewalung noch unstabil (kompliziert) fehler fähig, keine logout_bestätigung msg möglich nach session_destroy();

04.04
Dieser PR refactort die Klassenstruktur des Projekts grundlegend. Es wird eine abstrakte Basisklasse (aDatabank) und ein Interface (iDatenbank) eingeführt, von der alle Datenbankklassen erben. Gleichzeitig wird base_url.php zum zentralen Einstiegspunkt für Session-Start, DB-Verbindung und globale Funktions-Includes. Außerdem wird die neue Klasse Adress eingeführt inklusive DB-Migrationsskripten.

Architektur / OOP-Refactoring
Neu: classes/abstract/iDatenbank.php – Interface mit den CRUD-Methoden insert, select, delete, update, selectAll als Vertrag für alle Datenbankklassen.
Neu: classes/abstract/aDatabank.php – Abstrakte Klasse, die iDatenbank implementiert. Kapselt die PDO-Verbindungslogik (db()-Methode) zentral, sodass alle erbenden Klassen die Verbindung über $this->db() nutzen können, ohne eigene Verbindungslogik zu schreiben.
Refactored: classes/Person.php – Erbt jetzt von aDatabank statt direkt PDO zu empfangen. Der Konstruktor ruft $this->db() auf (geerbt). Externe require_once-Aufrufe für die DB-Verbindung wurden entfernt.
Neu: classes/Adress.php – Neue Klasse für Adressdaten, ebenfalls abgeleitet von aDatabank. Enthält insert() für neue Adressen und die statische Methode getAdresseByUserID() zum Abrufen der Adresse beim Login.

Zentralisierung der Includes (base_url.php)
config/base_url.php wurde zum globalen Bootstrap-File ausgebaut. Es übernimmt jetzt:

Session-Start (session_start() mit Status-Check)
require_once für db_conn.php
require_once für debug.php und msg.php

Dadurch werden redundante Einzel-Includes in login.php, logout.php, register.php und anderen Dateien bereinigt.


Neue Feature: Adresse nach Login
Die Login-Logik (include/funktionen/login.php) wurde erweitert: Nach erfolgreichem Login wird geprüft, ob der User bereits eine Adresse in der DB hat (Adress::getAdresseByUserID()). Falls nicht, wird er zum Adressformular weitergeleitet; andernfalls zu home.php.
Neu: include/templates/adresse_form.php und include/funktionen/adresse.php für die Adresseingabe.

DB-Migrationen
Drei SQL-Migrationsskripte wurden hinzugefügt, die die Beziehung zwischen users und adresse neu modellieren:

DateiBeschreibung001_drop_fk_from_users.sqlEntfernt den alten FK adresse_id aus der users-Tabelle002_add_users_id_to_adresse.sqlFügt user_id zur adresse-Tabelle hinzu (FK mit ON DELETE CASCADE)003_drop_table_laender.sqlEntfernt die laender-Tabelle und zugehörigen FK aus adresse
Die Beziehung wurde damit von users → adresse zu adresse → users umgekehrt (1 User hat 1 Adresse, FK liegt jetzt bei adresse).

Open Points / Hinweise

In logout.php ist der Auth-Check und die Redirect-Logik noch auskommentiert — sollte aktiviert oder entfernt werden.
insert() in Person.php verwendet noch String-Interpolation statt Prepared Statements — SQL-Injection-Risiko, sollte vor dem Merge gefixt werden.
Gleiches gilt für Adress::insert().
aDatabank hat Credential-Daten (root, leeres Passwort) hardcodiert — sollte auf .env / Konfigurationsdatei umgestellt werden.
Fehlermeldungen sind noch gemischt (Deutsch/Englisch).
Mehrere dd()-Debug-Aufrufe und auskommentierte header()-Redirects sind noch im Code.

5-5-2026
Add Klassen für jeder Table in der DB , die Tablen benutze die abstrackt klass zum erstellen ein DB vervindung 
alle klassen sind in einem namespace und werden mit autoloader importiert.
Add bootstrap file for session management and autoloading functionality.
refactor: Replace base_url.php with bootstrap.php for consistent configuration loading across files,remove require_once statment
refactor: Update Adress and Person classes for improved database interaction and property management
feat: Add classes for Fachbereiche, Nachricht, Raum, Seminar, Standort, Termin, and SessionController with CRUD operations
feat: Update database schema by dropping status table and adding status column to nachrichten and seminare tables
docs, Update Projekt verlauf