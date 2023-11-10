<?php

function returnHTML(): string {
  return <<<END
<head>
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
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
            margin-top: 8em;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
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
        <h2>Connexion</h2>
        <form action="index.php?action=signin" method="POST">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>

</html>
END;
}
?>


