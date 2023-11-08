<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un Tweet</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body>
    <h1>Supprimer un tweet</h1>
    <form method="post" action="index.php?action=delete-tweet">
        <label for="tweetId">ID du Tweet à supprimer :</label>
        <input type="text" id="tweetId" name="tweet_id" required>
        <button type="submit">Supprimer</button>
    </form>
    <button onclick="window.location.href='menu.php';">Retour au menu</button>
</body>
</html>
