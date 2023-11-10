<?php

function returnHTML(): string {
    return <<<END
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Poster un touite</title>
</head>
<body>
    <h2>Touite</h2>
    <form action="index.php?action=postTweet" method="POST" enctype="multipart/form-data">
        <label for="tweet">Touite :</label><br>
        <textarea id="tweet" name="message" required maxlength="235"></textarea><br>
        <label for="image">Image (optionnel) :</label><br>
        <input type="file" id="image" name="image"><br>
        <input type="submit" value="Touiter">
<button onclick="history.back();">Retour</button>
    </form>
</body>
</html>
END;
}
?>
