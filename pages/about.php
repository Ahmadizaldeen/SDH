<?php
require_once __DIR__ . "/../config/bootstrap.php";
require_once __DIR__."/../include/templates/head.php";
require_once __DIR__."/../include/templates/header.php";
?>

<nav>
	<?php require_once __DIR__ . "/../include/templates/navigation.php"; ?>
</nav>

<main>
<section>
  <h1>Über Uns</h1>

  <p>
    Willkommen auf dieser Übungswebseite – einem Ort, an dem Code wächst, Fehler leben und manchmal alles überraschend funktioniert.
  </p>

  <p>
    Diese Seite dient ausschließlich Lernzwecken und wurde entwickelt, um Webentwicklung praktisch zu verstehen.
    HTML, CSS, JavaScript und PHP treffen hier regelmäßig aufeinander – manchmal friedlich, manchmal eher nicht.
  </p>

  <h2>Unser Ziel</h2>

  <ul>
    <li>Saubere Webentwicklung lernen</li>
    <li>Strukturierte Projekte aufbauen</li>
    <li>Fehler verstehen statt ignorieren</li>
  </ul>

  <p>
    Wenn etwas hier nicht perfekt aussieht, ist das kein Fehler – sondern Teil des Lernprozesses.
  </p>
</section>
</main>
	
<?php require_once __DIR__."/../include/templates/footer.php";?>		