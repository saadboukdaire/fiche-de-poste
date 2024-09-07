<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="assets/fontawesome/css/all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du poste</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #001219; 
            margin: 0;
            padding: 0;
            color: #E9D8A6; 
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #005F73;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            border-radius: 5px;
        }
        .header {
            background-color: #0A9396;
            color: #E9D8A6; 
            padding: 10px;
            text-align: center;
            margin-top: 0;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .details {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .description {
            word-wrap: break-word;
        }
        .pdf-button, .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #94D2BD;
            color: #001219; 
            text-decoration: none;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s, color 0.3s;
        }
        .pdf-button:hover, .back-button:hover {
            background-color: #0A9396;
            color: #E9D8A6;
        }
        .button-container {
            text-align: center;
        }
        .pdf-button i {
            margin-right: 5px; 
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "saadweb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM fiche_pst WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <div class="container">
            <h2 class="header">Détails du poste</h2>
            <div class="details">
                <p><strong>Titre du poste:</strong> <?php echo htmlspecialchars($row['Titre_poste']); ?></p>
                <p><strong>Description:</strong> <span class="description"><?php echo htmlspecialchars($row['Description']); ?></span></p>
                <p><strong>Niveau d'éducation requis:</strong> <?php echo htmlspecialchars($row['Niveau_education']); ?></p>
                <p><strong>Expérience nécessaire:</strong> <?php echo htmlspecialchars($row['Experience']); ?></p>
                <p><strong>Compétences requises:</strong> <?php echo htmlspecialchars($row['Competences']); ?></p>
                <p><strong>Français requis:</strong> <?php echo htmlspecialchars($row['Francais']); ?></p>
                <p><strong>Anglais requis:</strong> <?php echo htmlspecialchars($row['Anglais']); ?></p>
                <p><strong>Arabe requis:</strong> <?php echo htmlspecialchars($row['Arabe']); ?></p>
                <p><strong>Ville:</strong> <?php echo htmlspecialchars($row['Ville']); ?></p>
                <p><strong>Date de création:</strong> <?php echo htmlspecialchars($row['date_creation']); ?></p>
            </div>
            
            <div class="button-container">
                <button onclick="printDetails()" class="pdf-button">
                    <i class="fa-solid fa-print" style="color: #000000;"></i> Imprimer
                </button>
                <a href="liste.php" class="back-button">Retour à la liste</a>
            </div>
        </div>

        <script>
            function printDetails() {
                window.print();
            }
        </script>
        <?php
    } else {
        echo "<div class='container'>Aucun résultat</div>";
    }
} else {
    echo "<div class='container'>ID manquant</div>";
}

$conn->close();
?>

</body>
</html>
