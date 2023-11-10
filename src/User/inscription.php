<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
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


        .container {
            background-color: #525050;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            margin-top:3em;

        }


        h1 {
            text-align: center;
            margin-bottom: 20px;
        }


        form {
            display: flex;
            flex-direction: column;
        }


        label {
            margin-bottom: 5px;
        }


        input[type="email"],
        input[type="password"],
        input[type="idUser"],
        input[type="Prenom"],
        input[type="Nom"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #474242;
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
        }


        input[type="submit"]:hover {
            background-color: slategrey;
        }
    </style>


</head>


<body>
    <div class="container">
        <h1>Inscription</h1>
        <form method="post" action="index.php?action=register">


            <label for="idUser">Pseudo:</label>
            <input type="idUser" id="idUser" name="idUser" required><br><br>


            <label for="Prenom">Prenom:</label>
            <input type="Prenom" id="Prenom" name="Prenom" required><br><br>


            <label for="Nom">Nom:</label>
            <input type="Nom" id="Nom" name="Nom" required><br><br>
           
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required><br><br>


            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required><br><br>


            <label for="confirm_password">Confirmez le mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>


            <input type="submit" value="S'inscrire">
        </form>
    </div>
</body>


</html>


