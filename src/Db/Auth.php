<?php

// namespace src\Auth;

class AuthException extends \Exception {}

class Auth {
    public static function authenticate($email, $password, $db) {
        $hashedPassword = self::getHashedPasswordFromDatabase($email, $db);
        if (password_verify($password, $hashedPassword)) {
            // Authentification réussie, créez un cookie
            $userId = self::getUserId($email, $db); // Obtenez l'ID de l'utilisateur
            setcookie('user_id', $userId, time() + 3600, '/'); // Le cookie expire dans 1 heure
            return true;
        } else {
            throw new AuthException("L'authentification a échoué. Veuillez vérifier vos identifiants.");
        }
    }

        public static function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

     public static function getUserId($email, $pdo)
    {
        $query = "SELECT idUser FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$userData) {
            throw new AuthException("Utilisateur non trouvé.");
        }

        return $userData['id'];
    }

public function register($email, $password, $confirmPassword) {
    if (strlen($password) < 10) {
        return "Le mot de passe doit avoir au moins 10 caractères.";
    }

    if ($password !== $confirmPassword) {
        return "Les mots de passe ne correspondent pas.";
    }

    if ($this->userExists($email)) {
        return "Un utilisateur avec cet e-mail existe déjà.";
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (email, password, role) VALUES (:email, :password, 1)";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();

    return "Inscription réussie !";
}


    public static function getHashedPassword($email, $db) {
        return self::getHashedPasswordFromDatabase($email, $db);
    }

    private static function getHashedPasswordFromDatabase($email, $db) {
    $sql = "SELECT `passwd` FROM `users` WHERE `email` = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
    $stmt->execute();
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($result) {
        return $result['passwd'];
    } else {
        echo "Echec de connexion";
    }
}
}
