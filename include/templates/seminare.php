<?php 
use Classes\Seminar;

$seminarObj = new Seminar();
$seminare = $seminarObj->getAllWithFachbereich();

$page = max(1, (int) ($_GET["page"] ?? 1));
$perPage = 9;
$total = count($seminare);
$offset = ($page - 1) * $perPage;
$seminarePage = array_slice($seminare, $offset, $perPage);
$hasNext = ($offset + $perPage) < $total;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminare</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/seminare.css">

    <style>

        *{
            box-sizing: border-box;
        }

        body{
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .container{
            width: 1200px;
            margin: auto;
        }

        /*
            3 x 3 Layout
        */
        .seminar-grid{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .seminar-card{
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            min-height: 300px;

            transition: 0.2s;
        }

        .seminar-card:hover{
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .seminar-title{
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .seminar-info{
            margin-bottom: 10px;
        }

        .status{
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #e8e8e8;
            font-size: 14px;
        }

        .btn-group{
            margin-top: 20px;

            display: flex;
            gap: 10px;
        }

        .btn{
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            color: white;
            text-align: center;
            flex: 1;
        }

        .details-btn{
            background-color: #0077cc;
        }

        .teilnahme-btn{
            background-color: #28a745;
        }

        .load-more{
            margin-top: 40px;
            text-align: center;
        }

        .load-more a{
            text-decoration: none;
            background-color: black;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
        }

    </style>
</head>
<body>

<?php msg(); ?>

<div class="container">

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
                        <span class="status">
                            <?= htmlspecialchars($seminar['status']) ?>
                        </span>
                    </div>

                </div>

                <div class="btn-group">

                    <!-- Einzelsicht -->
                    <a class="btn details-btn"
                       href="<?= BASE_URL ?>/pages/seminar.php?id=<?= (int) $seminar['id'] ?>">
                        Details
                    </a>

                    <!-- Teilnahme -->
                    <a class="btn teilnahme-btn"
                       href="<?= BASE_URL ?>/pages/seminar.php?id=<?= (int) $seminar['id'] ?>#termine">
                        Termine
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- Weitere Seminare laden -->
    <?php if ($hasNext): ?>
    <div class="load-more">

        <a href="<?= BASE_URL ?>/pages/seminare.php?page=<?= $page + 1 ?>">
            Weitere Seminare anzeigen
        </a>

    </div>
    <?php endif; ?>

</div>

</body>
</html>

