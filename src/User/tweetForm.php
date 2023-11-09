<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Poster un touite</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
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
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
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
