<?php
use Classes\Seminar;

$seminarObj = new Seminar();
$seminare   = $seminarObj->getAllWithFachbereich();

$page       = max(1, (int)($_GET['page'] ?? 1));
$perPage    = 9;
$total      = count($seminare);
$offset     = ($page - 1) * $perPage;
$seminarePage = array_slice($seminare, $offset, $perPage);
$hasNext    = ($offset + $perPage) < $total;
?>

<div class="sdh-content">

    <?php msg(); ?>

    <h1>Seminare</h1>

    <div class="seminar-grid">

        <?php foreach ($seminarePage as $seminar): ?>

            <div class="seminar-card">

                <div>
                    <div class="seminar-title">
                        <?= htmlspecialchars($seminar['title']) ?>
                    </div>

                    <div class="seminar-info">
                        <strong>Beschreibung:</strong><br>
                        <?= htmlspecialchars($seminar['beschreibung']) ?>
                    </div>

                    <div class="seminar-info">
                        <strong>Fachbereich:</strong>
                        <?= htmlspecialchars($seminar['fachbereich_name']) ?>
                    </div>

                    <div class="seminar-info">
                        <strong>Status:</strong>
                        <span class="seminar-status">
                            <?= htmlspecialchars($seminar['status']) ?>
                        </span>
                    </div>
                </div>

                <div class="seminar-btn-group">
                    <a class="btn btn-details"
                       href="<?= BASE_URL ?>/pages/seminar.php?id=<?= (int)$seminar['id'] ?>">
                        Details
                    </a>
                    <a class="btn btn-termine"
                       href="<?= BASE_URL ?>/pages/seminar.php?id=<?= (int)$seminar['id'] ?>#termine">
                        Termine
                    </a>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <?php if ($hasNext): ?>
    <div class="seminar-load-more">
        <a href="<?= BASE_URL ?>/pages/seminare.php?page=<?= $page + 1 ?>">
            Weitere Seminare anzeigen
        </a>
    </div>
    <?php endif; ?>

</div>