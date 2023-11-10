<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un Touite</title>
    <style>
        body {
            margin-left: 200px;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #474242;
            display: flex;
            flex-direction : column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            text-align: center;
            color: black;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            width: 80%;
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }

        label {
            font-weight: bold;
            margin-top: 20px;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 12px 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            font-size: 16px;
            resize: none;
        }

        input[type="file"] {
            margin-top: 20px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: grey;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: slategrey;
        }
    </style>
</head>
<body>
    <h1>Supprimer un touite</h1>
    <form method="post" action="index.php?action=delete-tweet">
        <label for="tweetId">ID du Touite à supprimer :</label>
        <input type="text" id="tweetId" name="tweet_id" required>
        <button type="submit">Supprimer</button>
    </form>
    <button onclick="window.location.href='menu.php';">Retour au menu</button>
</body>
</html>
