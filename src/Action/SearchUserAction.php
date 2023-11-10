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
                echo '<script>
                        window.location.href = "index.php?action=menu";
                        alert("Aucun utilisateur trouvé avec cet ID !");
                    </script>';
                return "Aucun utilisateur trouvé avec cet ID !";
            }
        } else {
            return "Veuillez entrer un ID d'utilisateur.";
        }
    }
}
