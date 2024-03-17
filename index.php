<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mein Browserspiel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="container">
    <div id="header">
        <h1>Willkommen in Galactica</h1>
    </div>
    <div id="main">
        <div id="sidebar">
            <?php
            require_once 'Game.class.php';

            // Neues Spiel erstellen und Spieler hinzufügen
            $game = new Game();
            $game->addPlayer("Spieler1");

            // Spielerdaten abrufen
            $player1 = $game->getPlayer("Spieler1");

            echo "<h2>Spieler: " . $player1->getUsername() . "</h2>";
            echo "<h3>Ressourcen:</h3>";
            $resources = $player1->getResources();
            echo "<ul>";
            foreach ($resources as $resource => $amount) {
                echo "<li>$resource: $amount</li>";
            }
            echo "</ul>";
            ?>
        </div>
        <div id="content">
        </div>
    </div>
    <div id="footer">
        <p>&copy; 2024 Galactica</p>
    </div>
</div>
</body>
</html>
