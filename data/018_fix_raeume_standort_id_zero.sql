USE sdh;

SET foreign_key_checks = 0;

-- 1) Einen gueltigen Fallback-Standort bestimmen (kleinste vorhandene ID)
SET @fallback_standort_id := (
    SELECT MIN(id) FROM standorte
);

-- 2) Bestehende fehlerhafte Werte korrigieren (0 oder NULL)
--    Nur ausfuehren, wenn es mindestens einen Standort gibt.
UPDATE raeume
SET standort_id = @fallback_standort_id
WHERE (standort_id = 0 OR standort_id IS NULL)
  AND @fallback_standort_id IS NOT NULL;

SET foreign_key_checks = 1;

-- 3) Optional: Ergebnis kontrollieren
SELECT id, name, standort_id
FROM raeume
ORDER BY id;
