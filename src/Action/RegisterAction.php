<?php
namespace src\Action;

use src\Db\connexionFactory;
use PDO;

class RegisterAction extends Action {
    public function execute(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $idUser = $_POST['idUser'];
            $Prenom = $_POST['Prenom'];
            $Nom = $_POST['Nom'];
            $confirmPassword = $_POST['confirm_password'];

            if ($password !== $confirmPassword) {
                return "Les mots de passe ne correspondent pas.";
            }

            if (strlen($password) < 8) {
                return "Le mot de passe doit avoir au moins 8 caractères.";
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $pdo = connexionFactory::makeConnection();

                $stmt = $pdo->prepare("INSERT INTO users (idUser, email, passwd, nbFollower, Prenom, Nom,  role) VALUES (:idUser, :email, :password, 0,  :Prenom, :Nom, 0)");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':idUser', $idUser);
                $stmt->bindParam(':Prenom', $Prenom);
                $stmt->bindParam(':Nom', $Nom);
                $stmt->execute();

                return "Inscription réussie !";
            } catch (PDOException $e) {
                return "Erreur d'inscription: " . $e->getMessage();
            }
        } else {
            ob_start();
            include 'src/User/inscription.php';
            return ob_get_clean();
        }
    }
}
