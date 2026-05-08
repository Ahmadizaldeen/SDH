# SDH – Seminarhaus Verwaltungssystem

> Projekt im Rahmen der Umschulung zum **Anwendungsentwickler**  
> Baustein: PHP-Webanwendung · Entwickler: Ahmad Izaldeen

---

## 📋 Projektübersicht

SDH ist eine vollständige webbasierte Verwaltungsplattform für ein Seminarhaus. Die Anwendung ermöglicht es Besuchern, Seminare zu entdecken und sich für Termine anzumelden – und gibt Administratoren ein eigenes, geschütztes Backend zur Verwaltung aller Inhalte.

Das Projekt wurde von Grund auf ohne Frameworks entwickelt und demonstriert den gesamten Entwicklungsprozess: von der Datenbankplanung über die objektorientierte PHP-Architektur bis hin zum fertigen Deployment.

---

## ✨ Features auf einen Blick

### Öffentliche Website
- **Seminarübersicht** mit Paginierung (9 Seminare pro Seite)
- **Seminar-Detailseite** mit allen zugehörigen Terminen, Räumen und Standorten
- **Registrierung & Login** mit Passwort-Hashing (bcrypt) und Session-Management
- **Seminar-Anmeldung** für eingeloggte Benutzer
- **Kontakt-, Impressum-, AGB- und About-Seite**
- Einheitliches, responsives Design

### Admin-Backend
- **Versteckter Zugang** – das Admin-Login ist nur über eine geheime URL erreichbar, nicht verlinkt oder öffentlich auffindbar
- **Dashboard** mit Statistik-Karten (Anzahl Seminare, Termine, Standorte, Räume, Benutzer)
- **CRUD-Verwaltung** aller Kerntabellen: Seminare, Termine, Standorte, Räume, Fachbereiche, Benutzer, Nachrichten
- **Formularbasiertes Bearbeiten & Anlegen** neuer Einträge (Edit via GET `?id=`, Switch-Router via GET `?view=`)
- Eigenes, vom Frontend unabhängiges Admin-Design (Dark Mode)

---

## 🛠️ Technischer Stack

| Bereich | Technologie |
|---|---|
| Backend | PHP 8 (OOP, Namespaces, Traits, Interfaces) |
| Datenbank | MySQL 8 mit PDO |
| Frontend | HTML5, CSS3 (kein Framework) |
| Architektur | MVC-ähnliches Template-System |
| Sicherheit | bcrypt, XSS-Schutz, PDO Prepared Statements, Session-Guard, Whitelist-Validierung |
| Versionskontrolle | Git / GitHub (Feature-Branch-Workflow) |
| Server | Apache (XAMPP / lokaler Entwicklungsserver) |

---

## 🏗️ Architektur

### Objektorientiertes Design

Das Projekt nutzt ein selbst entwickeltes **ActiveRecord-Pattern**. Jede Entität (Seminar, Termin, Standort, Raum usw.) erbt von einer abstrakten Basisklasse und implementiert ein Interface:

```
iDatabank (Interface)
    └── aDatabank (Abstrakte Klasse)
            ├── Seminar
            ├── Termin
            ├── Standort
            ├── Raum
            ├── Fachbereiche
            ├── Person
            ├── Adress
            └── Nachricht
```

Alle Klassen bieten einheitliche CRUD-Methoden: `insert()`, `select($id)`, `update($id)`, `delete($id)`, `selectAll()`.

### Verzeichnisstruktur

```
SDH/
├── admin/                  ← Geschützter Admin-Bereich
│   ├── hamburg/2026/       ← Geheime Einstiegs-URL
│   ├── aktionen/           ← POST-Handler (insert, update, delete)
│   ├── templates/          ← Admin-Templates (Tabellen & Formulare)
│   └── css/admin.css       ← Eigenständiges Admin-Styling
├── classes/                ← Alle Domänenklassen (OOP)
│   ├── abstract/           ← Interface & abstrakte Basisklasse
│   └── Traits/             ← SessionController-Trait
├── config/
│   └── bootstrap.php       ← Autoloader, Session, DB-Verbindung, Hilfsfunktionen
├── css/style.css           ← Öffentliches Styling
├── data/
│   └── DB_SCHEMA_BACKUP/   ← Alle 18 Migrationsskripte (001–018)
├── docs/                   ← UML-Diagramme, Projektverlauf, Klausuraufgabe
├── include/
│   ├── funktionen/         ← Login, Logout, Register, Validierung
│   └── templates/          ← Wiederverwendbare HTML-Templates
├── pages/                  ← Alle öffentlichen Seiten
└── index.php               ← Einstiegspunkt → Redirect zu home.php
```

### Datenbankschema (vereinfacht)

```
users ──────── adresse
  │
  └── users_termine ─── termine ─── seminare ─── fachbereiche
                            │
                          raeume ─── standorte
```

---

## 🚀 Installation & Setup

### Voraussetzungen
- PHP 8.0 oder höher
- MySQL 8.0 oder höher
- Apache mit `mod_rewrite` (XAMPP empfohlen für lokale Entwicklung)

### Schritt-für-Schritt

**1. Repository klonen**
```bash
git clone https://github.com/Ahmadizaldeen/SDH.git
cd SDH
```

**2. Datenbank einrichten**

Alle Migrationen in einem Schritt (empfohlen):
```sql
-- In phpMyAdmin oder MySQL-CLI:
source data/000_018_mirgration_scripte.sql
```

Oder einzeln, der Reihenfolge nach:
```bash
# Dateien in data/DB_SCHEMA_BACKUP/ von 001 bis 018 ausführen
```

> ⚠️ `LOAD DATA LOCAL INFILE` muss für die Seed-Daten aktiviert sein (`local_infile=1` in `my.cnf`)

**3. Datenbankverbindung anpassen**

In `config/bootstrap.php` die Zugangsdaten anpassen:
```php
$servername = "localhost";
$username   = "dein_benutzer";
$password   = "dein_passwort";
$dbname     = "sdh";
```

**4. Admin-Passwort setzen**

In `admin/funktionen/admin_login.php` einen eigenen Hash eintragen:
```php
// Neuen Hash generieren:
echo password_hash('deinPasswort', PASSWORD_DEFAULT);

// Hash in der Datei ersetzen:
define('ADMIN_PASS', 'dein_generierter_hash');
```

**5. Webserver starten**

Projektordner als Document Root konfigurieren. Die Startseite ist dann erreichbar unter:
```
http://localhost/SDH/
```

---

## 🔐 Sicherheitskonzept

| Maßnahme | Umsetzung |
|---|---|
| Passwörter | bcrypt-Hashing mit `password_hash()` / `password_verify()` |
| SQL-Injection | Ausschließlich PDO Prepared Statements |
| XSS | `htmlspecialchars()` bei allen Ausgaben |
| Admin-Zugang | Session-Guard (`admin_guard()`) auf allen Admin-Seiten |
| Versteckter Login | Admin-Login nur über geheime URL erreichbar |
| Tabellen-Whitelist | INSERT/UPDATE/DELETE nur auf erlaubten Tabellen möglich |
| Session-Einmaltoken | `$_SESSION['admin_url']` wird nach Logout zurückgesetzt |

---

## 📈 Entwicklungsprozess

Das Projekt wurde in mehreren Git-Feature-Branches entwickelt und schrittweise in `main` gemergt:

| Branch | Inhalt |
|---|---|
| `docs/projekt_start` | Projektplanung, UML, Use-Case-Diagramm |
| `feat/Projekt-Classes` | Alle Domänenklassen, ActiveRecord-Pattern, Bootstrap |
| `feat/Data-Migration` | 13 SQL-Migrationsskripte + Seed-Daten (CSV) |
| `feat/templeting` | PHP-Templatesystem, alle öffentlichen Seiten, CSS |
| `feat/backend_admin_branch` | Vollständiges Admin-Backend mit CRUD |
| `test/fix_bugs_degsin` | Bugfixes: doppelter HTML-Wrapper, CSS-Bereinigung |
| `release/v1.0` | Routing-Einstiegspunkt, versteckter Admin-Zugang, DB-Backup |

---

## 📚 Projektkontext

Dieses Projekt entstand als **Klausurprojekt** im Baustein PHP der Umschulung zum Fachinformatiker Anwendungsentwicklung. Es demonstriert den selbstständigen Aufbau einer vollständigen Webanwendung – von der ersten Datenbankplanung bis zur lauffähigen v1.0.

**Entwicklungszeitraum:** April – Mai 2026  
**Schule:** EDV-Schule / Umschulungsträger

**Erlernte und angewendete Konzepte:**
- Objektorientierte Programmierung (Klassen, Vererbung, Interfaces, Traits, Namespaces)
- Datenbankdesign (Normalisierung, Fremdschlüssel, UML-Klassendiagramm)
- MVC-ähnliche Architektur ohne Framework
- Sicheres Session-Management und Authentifizierung
- Git-Workflow mit Feature-Branches
- SQL-Migrationen und Datenbank-Versionierung

---

## 👤 Entwickler

**Ahmad Izaldeen**  
Umschüler zum Fachinformatiker Anwendungsentwicklung  
GitHub: [github.com/Ahmadizaldeen](https://github.com/Ahmadizaldeen)

---

*SDH – entwickelt mit PHP, MySQL und viel Kaffee ☕*
