<?php
namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class SearchUserAction extends Action {
    public function execute(): string {
        if (isset($_GET['userId'])) {
            $userId = $_GET['userId'];
            $db = connexionFactory::makeConnection();

            $stmt = $db->prepare("SELECT * FROM users WHERE idUser = :userId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Rediriger l'utilisateur vers la page du profil de l'utilisateur trouvé
                header("Location: /profile?userId=" . urlencode($userId));
                exit();
            } else {
                return "Utilisateur non trouvé.";
            }
        } else {
            return "Veuillez entrer un ID d'utilisateur.";
        }
    }
}
