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
  <h1>Allgemeine Geschäftsbedingungen</h1>

  <h2>§1 Geltungsbereich</h2>
  <p>
    Diese Webseite ist ein Lernprojekt. Mit der Nutzung akzeptierst du, dass nicht alles produktionsreif ist.
  </p>

  <h2>§2 Inhalte</h2>
  <ul>
    <li>Inhalte können sich jederzeit ändern</li>
    <li>Funktionen können experimentell sein</li>
    <li>Design kann sich spontan entwickeln</li>
  </ul>

  <h2>§3 Haftung</h2>
  <p>
    Für Fehler, Bugs oder unerwartetes Verhalten wird keine Haftung übernommen.
  </p>

  <h2>§4 Schluss</h2>
  <p>
    Wenn alles funktioniert: nicht anfassen.
  </p>
</section>
</main>
	
<?php require_once __DIR__."/../include/templates/footer.php";?>	