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
    if (isset($_POST['id'], $_POST['Titre_poste'], $_POST['Description'], $_POST['Niveau_education'], $_POST['Experience'], $_POST['Francais'], $_POST['Anglais'], $_POST['Arabe'], $_POST['ville'])) {
        
        $id = intval($_POST['id']);
        $titre_poste = trim($_POST['Titre_poste']);
        $description = trim($_POST['Description']);
        $niveau_education = intval($_POST['Niveau_education']);
        $experience = intval($_POST['Experience']);
        $francais = trim($_POST['Francais']);
        $anglais = trim($_POST['Anglais']);
        $arabe = trim($_POST['Arabe']);
        $ville = trim($_POST['ville']);
        if ($experience < 2 || $experience > 40 || !in_array($niveau_education, [2, 3, 5])) {
            echo "<div style='font-family: Arial, sans-serif; background-color: #191970; color: #F5F5F5; padding: 20px; border-radius: 5px;'>Vous devez avoir au moins une licence et avoir deux ans d'expérience.</div>";
        } else {
            $stmt = $conn->prepare("UPDATE fiche_pst SET 
                                        Titre_poste=?, 
                                        Description=?, 
                                        Niveau_education=?, 
                                        Experience=?, 
                                        Francais=?, 
                                        Anglais=?, 
                                        Arabe=?, 
                                        Ville=? 
                                    WHERE id=?");
            $stmt->bind_param("ssisssssi", $titre_poste, $description, $niveau_education, $experience, $francais, $anglais, $arabe, $ville, $id);

            if ($stmt->execute()) {
                echo "<div style='font-family: Arial, sans-serif; background-color: #191970; color: #F5F5F5; padding: 20px; border-radius: 5px;'>Données mises à jour avec succès</div>";
            } else {
                echo "Erreur lors de la mise à jour : " . $stmt->error;
            }
            
            $stmt->close();
        }
    } else {
        echo "<div style='font-family: Arial, sans-serif; background-color: #191970; color: #F5F5F5; padding: 20px; border-radius: 5px;'>Veuillez remplir tous les champs requis</div>";
    }
} else {
    echo "Requête invalide.";
}

$conn->close();
?>

<a href="liste.php" style="font-family: Arial, sans-serif; display: block; margin-top: 20px; background-color: #FFD700; color: #191970; padding: 10px 20px; text-align: center; border-radius: 5px; text-decoration: none;">Retour à la liste</a>
