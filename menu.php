<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu HTML</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Lien vers le CDN Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<body>
    <div id="menu">
        <div id="logo">
            <img src="img/logo.png" alt="Logo">
            <h4>Touiter.app</h4>
        </div>
        <ul>
            <?php if (!isset($_COOKIE['user_id'])): ?>
                <li class="element_menu"><i class="bi bi-person-lines-fill"></i> <a href="index.php?action=register">Register</a></li>
                <li class="element_menu"><i class="bi bi-box-arrow-in-right"></i> <a href="index.php?action=signin">Log-in</a></li>
            <?php else: ?>
                <li class="element_menu"><i class="bi bi-person-square"></i><a href="index.php?action=profileAction"> Profile</a></li>
                <li class="element_menu"><i class="bi bi-chat-dots"></i> <a href="index.php?action=tweetForm">Poster un Touite</a></li>
                <li class="element_menu"><i class="bi bi-chat-dots"></i> <a href="index.php?action=delete-tweet">Supprimer un Touite</a></li>
                <li class="element_menu"><i class="bi bi-chat-dots"></i> <a href="index.php?action=listTag">Liste des tag</a></li>
                <li class="element_menu"><i class="bi bi-chat-dots"></i> <a href="index.php?action=followUser">Liste des User</a></li>
            <?php endif; ?>
        </ul>
        <div id="deconnexion">
            <li class="element_menu"><i class="bi bi-box-arrow-in-left"></i> Deconnexion</li>
        </div>
    </div>
</body>
</html>
