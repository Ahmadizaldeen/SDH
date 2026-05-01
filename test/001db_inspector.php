
<?php
/* tabellen und spalten in Browser anzeigen : SHOW TABLES, DESCRIBE table*/
require_once '../config/db_conn.php';
require_once '../include/debug.php';

echo "<h2>Datenbank-Inspector</h2>";

// 1. Tabellen holen
$stmt = $db->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_NUM);// nummerische Indizes
#dd($tables);
foreach ($tables as $table) {

    $tableName = $table[0];
    echo "<h3>Tabelle: $tableName</h3>";

    // 2. Spalten holen
    $columnsStmt = $db->query("DESCRIBE `$tableName`");
    $columns = $columnsStmt->fetchAll(PDO::FETCH_ASSOC);
    #dd($columns);
    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
            <th>Feld</th>
            <th>Typ</th>
            <th>Null</th>
            <th>Key</th>
            <th>Default</th>
            <th>Extra</th>
            </tr>";

    foreach ($columns as $col) {
        echo "<tr>
                <td>{$col['Field']}</td>
                <td>{$col['Type']}</td>
                <td>{$col['Null']}</td>
                <td>{$col['Key']}</td>
                <td>{$col['Default']}</td>
                <td>{$col['Extra']}</td>
                </tr>";
    }

    echo "</table><br>";
}

?>

