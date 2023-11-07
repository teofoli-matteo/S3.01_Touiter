<?php

require_once 'Auth.php';
require_once 'connexionFactory.php';

//use src\Db\Auth;
// use src\Db\AuthException;

\src\Db\connexionFactory::setConfig('db.config.ini');
$db = \src\Db\connexionFactory::makeConnection();

$redirectId = isset($_POST['redirect_id']) ? intval($_POST['redirect_id']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $hashedPassword = Auth::getHashedPassword($email, $db);

        if (password_verify($password, $hashedPassword)) {
            $userId = Auth::getUserId($email, $db);

            // Créez un cookie pour stocker l'ID de l'utilisateur
            setcookie('user_id', $userId, time() + 3600, '/'); // Le cookie expire dans 1 heure

            // Redirigez l'utilisateur vers la page principale
            header("Location: /index.php");
            exit();
        } else {
            throw new AuthException("L'authentification a échoué. Veuillez vérifier vos identifiants.");
        }
    } catch (AuthException $e) {
        echo "Erreur d'authentification: " . $e->getMessage();
    }
}

?>
