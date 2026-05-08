<?php

use Classes\Person;
use Classes\Seminar;
use Classes\Termin;

$seminarId = (int) ($_GET["id"] ?? 0);
if ($seminarId < 1) {
    http_response_code(404);
    exit("Seminar nicht gefunden");
}

$obj = new Seminar();
$termine = $obj->selectWithTermine($seminarId);

$seminar = $termine[0] ?? null;

if (!$seminar) {
    http_response_code(404);
    exit("Seminar nicht gefunden");
}

$terminListe = array_values(array_filter($termine, function ($row) {
    return !empty($row["termin_id"]);
}));

$terminObj = new Termin();
$loggedIn = Person::isLoggedIn();

?>


<body>

<?php msg(); ?>

<div class="container">

    <div class="seminar-card">

        <!-- Bild -->
        <?php if(!empty($seminar['bild'])): ?>

            <img 
                class="seminar-image"
                src="<?= htmlspecialchars($seminar['bild']) ?>"
                alt="Seminar Bild"
            >

        <?php endif; ?>


        <!-- Titel -->
        <div class="seminar-title">
            <?= htmlspecialchars($seminar['title']) ?>
        </div>


        <!-- Beschreibung -->
        <div class="seminar-beschreibung">
            <?= nl2br(htmlspecialchars($seminar['beschreibung'])) ?>
        </div>


        <!-- Informationen -->
        <div class="info-grid">

            <div class="info-box">
                <div class="info-title">
                    Fachbereich
                </div>

                <?= htmlspecialchars($seminar['fachbereich_name']) ?>
            </div>


            <div class="info-box">
                <div class="info-title">
                    Status
                </div>

                <span class="status">
                    <?= htmlspecialchars($seminar['status']) ?>
                </span>
            </div>


            <div class="info-box">
                <div class="info-title">
                    Mindestteilnehmer
                </div>

                <?= htmlspecialchars($seminar['min_teilnehmer']) ?>
            </div>


            <div class="info-box">
                <div class="info-title">
                    Maximalteilnehmer
                </div>

                <?= htmlspecialchars($seminar['max_teilnehmer']) ?>
            </div>


            <div class="info-box">
                <div class="info-title">
                    Preis
                </div>

                <?= htmlspecialchars($seminar['preis']) ?> €
            </div>

        </div>

        <h2 id="termine">Termine</h2>
        <hr>

<?php if (!empty($terminListe)): ?>

    <?php foreach ($terminListe as $termin): ?>
        <?php
            $tid = (int) $termin["termin_id"];
            $terminStatus = $loggedIn ? $terminObj->getStatus($tid) : "";
        ?>

        <div style="background:#fafafa; padding:15px; margin-bottom:10px; border-radius:8px;">

            <p>
                <strong>Beginn:</strong>
                <?= htmlspecialchars((string) ($termin["beginn"] ?? "")) ?>
            </p>

            <p>
                <strong>Ende:</strong>
                <?= htmlspecialchars((string) ($termin["ende"] ?? "")) ?>
            </p>

            <p>
                <strong>Dauer:</strong>
                <?= htmlspecialchars((string) ($termin["dauer"] ?? "")) ?>
            </p>

            <p>
                <strong>Standort:</strong>
                <?= htmlspecialchars((string) ($termin["standort_name"] ?? "")) ?>
            </p>

            <p>
                <strong>Raum:</strong>
                <?= htmlspecialchars((string) ($termin["raum_name"] ?? "")) ?>
            </p>

            <p>
                <?php if (!$loggedIn): ?>
                    <a href="<?= BASE_URL ?>/pages/login.php">Einloggen zum Anmelden</a>
                <?php elseif ($terminStatus === "frei"): ?>
                    <a href="<?= BASE_URL ?>/pages/anmelden.php?termin_id=<?= $tid ?>">Anmelden</a>
                <?php else: ?>
                    <span>Ausgebucht</span>
                <?php endif; ?>
            </p>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <p>Keine Termine vorhanden</p>

<?php endif; ?>


        <!-- Buttons -->
        <div class="button-group">

            <!-- Teilnahme -->
            <a 
                class="btn btn-teilnahme"
                href="#termine"
            >
                Zu den Terminen
            </a>

            <!-- Zurück -->
            <a 
                class="btn btn-back"
                href="<?= BASE_URL ?>/pages/seminare.php"
            >
                Zurück
            </a>

        </div>

    </div>

</div>

</body>
