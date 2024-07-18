<?php 
$page = 'Liste';
include 'header.php'; 
?>
<div class="container">
    <div class="starter-template">
        <h1 id="header">Liste des fiches</h1>
    </div>
</div>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des fiches</title>
    <link rel="stylesheet" href="assets/css/saad.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            text-align: left;
        }
        .toggle-competences {
            color: #1A237E;
            text-decoration: none;
        }
        .competences-description {
            max-height: 50px;
            overflow: hidden;
            transition: max-height 0.5s;
        }
        .more-text {
            display: none;
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

$sql = "SELECT COUNT(*) AS total FROM fiche_pst";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_records = $row['total'];
$records_per_page = 4; 
$total_pages = ceil($total_records / $records_per_page);
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($total_pages, $current_page)); 
$start_from = ($current_page - 1) * $records_per_page;
$sql = "SELECT * FROM fiche_pst LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row_count = 0;
    ?>
    <table>
        <tr style="background-color: #03045e; color: white;">
            <th style="border:none; padding: 10px; text-align: left;">Titre_poste</th>
            <th style="border:none; padding: 10px; text-align: left;">Niveau_education</th>
            <th style="border: none; padding: 10px; text-align: left;">Experience</th>
            <th style="border: none; padding: 10px; text-align: left; width: 50%;">Compétences</th>
            <th style="border: none; padding: 10px; text-align: left;">Français</th>
            <th style="border: none; padding: 10px; text-align: left;">Anglais</th>
            <th style="border: none; padding: 10px; text-align: left;">Arabe</th>
            <th style="border: none; padding: 10px; text-align: left;">Ville</th>
            <th style="border:none; padding: 10px; text-align: left;">date_creation</th>
            <th style="border: none; padding: 10px; text-align: left; width: 50%;">Actions</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            $row_count++;
            $row_color = $row_count % 2 == 0 ? "#0077b6" : "#00b4d8";
            ?>
            <tr style="background-color: <?php echo $row_color; ?>; color: #caf0f8;">
                <td style="border: none; padding: 10px;"><?php echo $row["Titre_poste"]; ?></td>
                <td style="border: none; padding: 10px;"><?php echo $row["Niveau_education"]; ?></td>
                <td style="border: none; padding: 10px;"><?php echo $row["Experience"]; ?></td>
                <td style="border: none; padding: 10px; width: 50%;">
                    <div class="competences-description">
                        <?php echo isset($row["Competences"]) ? substr($row["Competences"], 0, 7) : 'Compétence invalide'; ?>
                        <?php if (strlen($row["Competences"]) > 7) { ?>
                            <span class="more-text"><?php echo substr($row["Competences"], 7); ?></span>
                        <?php } ?>
                    </div>
                    <?php if (strlen($row["Competences"]) > 7) { ?>
                        <a href="#" class="toggle-competences">Afficher plus</a>
                    <?php } ?>
                </td>
                <td style="border: none; padding: 10px;"><?php echo $row["Francais"]; ?></td>
                <td style="border: none; padding: 10px;"><?php echo $row["Anglais"]; ?></td>
                <td style="border: none; padding: 10px;"><?php echo $row["Arabe"]; ?></td>
                <td style="border: none; padding: 10px;"><?php echo $row["Ville"]; ?></td>
                <td style="border:none; padding: 10px;"><?php echo $row["date_creation"]; ?></td>
                <td style="border: none; padding: 10px; text-align: center;">
                    <form action="modifier.php" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit"><i class="fa-solid fa-pen-to-square"></i></button>
                    </form>
                    <form action="supprimer.php" method="post" style="display: inline;" onsubmit="return confirmDeletion();">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    <form action="inspecter.php" method="get" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit"><i class="fa-solid fa-circle-info"></i></button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

    <script>
        function confirmDeletion() {
            return confirm("Êtes-vous sûr de bien vouloir supprimer cet élément?");
        }

        document.querySelectorAll('.toggle-competences').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const competencesDiv = toggle.previousElementSibling;
                const moreText = competencesDiv.querySelector('.more-text');

                if (moreText.style.display === 'none') {
                    competencesDiv.style.maxHeight = 'none';
                    moreText.style.display = 'inline';
                    toggle.textContent = 'Afficher moins';
                } else {
                    competencesDiv.style.maxHeight = '50px'; // Adjust the height here
                    moreText.style.display = 'none';
                    toggle.textContent = 'Afficher plus';
                }
            });
        });
    </script>

    <?php
    echo '<div class="pagination" style="text-align: center; margin: 20px 0;">';
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            echo '<a href="liste.php?page=' . $i . '" style="margin: 0 5px; text-decoration: none; background-color: #03045e; color: #caf0f8; padding: 5px 10px; border: 1px solid #e0e1dd; border-radius: 3px;">' . $i . '</a>';
        } else {
            echo '<a href="liste.php?page=' . $i . '" style="margin: 0 5px; text-decoration: none; background-color: #0077b6; color: #caf0f8; padding: 5px 10px; border: 1px solid #D3D3D3; border-radius: 3px;">' . $i . '</a>';
        }
    }
    echo '</div>';
} else {
    echo "<p>Pas de résultats.</p>";
}

$conn->close();
?>

</body>
</html>
