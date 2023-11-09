<?php
use src\Db\connexionFactory;
use PDO;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["idTouite"])) {
        $idTouite = $_POST["idTouite"];

        try {
            $pdo = connexionFactory::makeConnection();
            $stmt = $pdo->prepare("DELETE FROM touite WHERE idTouite = :idTouite");
            $stmt->bindParam(':idTouite', $idTouite);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression du touite: " . $e->getMessage();
            exit();
        }

        // Actualiser la page après la suppression
        echo '<script>refreshPage();</script>';
    }
}
?>
