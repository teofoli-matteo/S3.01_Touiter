<?php
namespace src\Action;
require_once 'action.php';
// \src\Db\connexionFactory::setConfig('db.config.ini');
use src\Db\connexionFactory;

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
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    if (strlen($password) < 8) {
        echo "Le mot de passe doit avoir au moins 8 caractères.";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo = connexionFactory::makeConnection();


        $stmt = $pdo->prepare("INSERT INTO users (idUser, email, passwd, nbFollower, Prenom, Nom,  role) VALUES (:idUser, :email, :password, 0,  :Prenom, :Nom, 1)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':Prenom', $Prenom);
        $stmt->bindParam(':Nom', $Nom);
        $stmt->execute();

        echo "Inscription réussie !";
    } catch (PDOException $e) {
        echo "Erreur d'inscription: " . $e->getMessage();
    }
}else {
            ob_start();
            include 'src/User/inscription.php';
            return ob_get_clean();
        }
    }
}