<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Poster un touite</title>
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
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            width: 400px;
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
            background-color: darkgray;
            color: black;
            border: none;
            border-radius: 5px;
            padding: 15px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            width: 150px;
            margin-left: auto;
            margin-right: auto; /* Added to center the button horizontally */
        }

        input[type="submit"]:hover {
            background-color: slategrey;
        }

        h2 {
            color: white;
        }
    </style>
</head>
<body>
    <h2>Laissez libre court à votre imagination ! TOUITEZ !</h2>
    <form action="index.php?action=postTweet" method="POST" enctype="multipart/form-data">
        <label for="tweet">Touite :</label><br>
        <textarea id="tweet" name="message" required maxlength="235"></textarea><br>
        <label for="image">Image (optionnel) :</label><br>
        <input type="file" id="image" name="image"><br>
        <input type="submit" value="Touiter">
    </form>
</body>
</html>
