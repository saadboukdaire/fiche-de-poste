

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "saadweb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        $id = $_POST["id"];

        $stmt = $conn->prepare("DELETE FROM fiche_pst WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<div style='font-family: Arial, sans-serif; background-color: #191970; color: #F5F5F5; padding: 20px; border-radius: 5px;'>Enregistrement supprimé avec succès</div>";
        } else {
            echo "Erreur lors de la suppression de l'enregistrement : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ID non valide.";
    }
} else {
    echo "Requête invalide.";
}

$conn->close();
?>

<a href="liste.php" style="font-family: Arial, sans-serif; display: block; margin-top: 20px; background-color: #FFD700; color: #191970; padding: 10px 20px; text-align: center; border-radius: 5px; text-decoration: none;">Retour à la liste</a>
