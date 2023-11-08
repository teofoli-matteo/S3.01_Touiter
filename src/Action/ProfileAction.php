<?php
namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class ProfileAction extends Action {
    private $userId;
    private $userDetails;

    public function __construct($userId) {
        $this->userId = $userId;
    }

    public function execute(): string {
        $db = connexionFactory::makeConnection();

        // Récupérer les détails de l'utilisateur à partir de la base de données en fonction de $this->userId
        $stmt = $db->prepare("SELECT * FROM Users WHERE idUser = :userId");
        $stmt->bindParam(':userId', $this->userId, PDO::PARAM_STR);
        $stmt->execute();
        $this->userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Profil de l'utilisateur</title>
            <link rel="stylesheet" href="path/to/your/styles.css">
        </head>
        <body>
            <h1>Profil de l'utilisateur <?php echo $this->userDetails['username']; ?></h1>
            <!-- Affichez les détails de l'utilisateur ici -->
            <p>Nom d'utilisateur : <?php echo $this->userDetails['username']; ?></p>
            <p>Email : <?php echo $this->userDetails['email']; ?></p>
            <!-- Ajoutez d'autres détails de l'utilisateur ici selon votre base de données -->
        </body>
        </html>
        <?php

        return ob_get_clean();
    }
}
