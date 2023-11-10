<?php
namespace src\Action;

use src\Db\connexionFactory;

class SigninAction extends Action {
    public function execute(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            try {
                $pdo = connexionFactory::makeConnection();

                $stmt = $pdo->prepare("SELECT idUser, email, passwd FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['passwd'])) {
                    // Authentification réussie
                    session_start();
                    $_SESSION['user_id'] = $user['idUser'];

                    // Création d'un cookie avec l'idUser
                    setcookie('user_id', $user['idUser'], time() + 3600, '/'); // Le cookie expire dans 1 heure

                    // renvoi vers le menu.php
                    header('Location: index.php');
                    exit();
                } else {
                    echo "L'authentification a échoué. Veuillez vérifier vos identifiants.";
                }
            } catch (\PDOException $e) {
                echo "Erreur d'authentification: " . $e->getMessage();
            }
        } else {
            ob_start();
            include 'src/User/login.php';
            return returnHTML();
        }

        return '';
    }
}
?>
