<!-- tweetForm.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tweeter</title>
</head>
<body>
    <h2>Tweeter</h2>
    <form action="index.php?action=postTweet" method="POST" enctype="multipart/form-data">
        <label for="tweet">Tweet :</label><br>
        <textarea id="tweet" name="message" required></textarea><br>
        <label for="image">Image (optionnel) :</label><br>
        <input type="file" id="image" name="image"><br>
        <input type="submit" value="Tweeter">
    </form>
</body>
</html>
