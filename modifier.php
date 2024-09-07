<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "saadweb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$id = null;
$titre_poste = '';
$description = '';
$niveau_education = '';
$experience = '';
$francais = '';
$anglais = '';
$arabe = '';
$ville = '';
$error_message = ''; 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT * FROM fiche_pst WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $titre_poste = $row['Titre_poste'];
        $description = $row['Description'];
        $niveau_education = $row['Niveau_education'];
        $experience = $row['Experience'];
        $francais = $row['Francais'];
        $anglais = $row['Anglais'];
        $arabe = $row['Arabe'];
        $ville = $row['Ville'];
    } else {
        echo "Aucun enregistrement trouvé avec l'ID $id";
        exit();
    }
}

$poste_query = "SELECT id_poste, Titre_poste FROM postes";
$postes = $conn->query($poste_query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #415a77;
        }
        form {
            background-color: #e0e1dd;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #1A237E;
            border-radius: 10px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #1A237E;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            background-color: #1A237E;
            color: #FFD700;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #FFD700;
            color: #1A237E;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
    <script>
        function validateForm() {
            const experience = parseInt(document.querySelector('[name="Experience"]').value);
            const niveauEducation = parseInt(document.querySelector('[name="Niveau_education"]').value);

            if (experience < 2 || experience > 40 || ![2, 3, 5].includes(niveauEducation)) {
                alert("Vous devez avoir bac+3 ou bac+5 et avoir 2 a 40 ans d'experience.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2 style="text-align: center;margin-bottom:20px;background-color:#e0e1dd;margin: auto; max-width: 600px; padding: 10px 20px;border: none;border-radius: 5px;cursor: pointer;">Modifier la Fiche Poste</h2>
    <form action="update.php" method="post" onsubmit="return validateForm();">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div>
            <label for="poste">Titre de poste</label>
            <select id="poste" name="Titre_poste" required>
                <?php
                if ($postes->num_rows > 0) {
                    while ($poste = $postes->fetch_assoc()) {
                        $selected = ($poste["Titre_poste"] == $titre_poste) ? 'selected' : '';
                        echo "<option value='" . $poste["Titre_poste"] . "' $selected>" . $poste["Titre_poste"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No Job Titles Available</option>";
                }
                ?>
            </select>
        </div>
        
        <label for="Description">Description :</label>
        <textarea name="Description" required><?php echo $description; ?></textarea>
        
        <label for="Niveau_education">Niveau d'éducation :</label>
        <input type="text" name="Niveau_education" value="<?php echo $niveau_education; ?>" required>
        
        <label for="Experience">Expérience :</label>
        <input type="text" name="Experience" value="<?php echo $experience; ?>" required>
        
        <label for="Francais">Français :</label>
        <select name="Francais" required>
            <option value="debutant" <?php if($francais == 'debutant') echo 'selected'; ?>>debutant</option>
            <option value="intermediaire" <?php if($francais == 'intermediaire') echo 'selected'; ?>>intermediaire</option>
            <option value="courant" <?php if($francais == 'courant') echo 'selected'; ?>>courant</option>
        </select>
 
        <label for="Anglais">Anglais :</label>
        <select name="Anglais" required>
            <option value="debutant" <?php if($anglais == 'debutant') echo 'selected'; ?>>debutant</option>
            <option value="intermediaire" <?php if($anglais == 'intermediaire') echo 'selected'; ?>>intermediaire</option>
            <option value="courant" <?php if($anglais == 'courant') echo 'selected'; ?>>courant</option>
        </select>

        <label for="Arabe">Arabe :</label>
        <select name="Arabe" required>
            <option value="debutant" <?php if($arabe == 'debutant') echo 'selected'; ?>>debutant</option>
            <option value="intermediaire" <?php if($arabe == 'intermediaire') echo 'selected'; ?>>intermediaire</option>
            <option value="courant" <?php if($arabe == 'courant') echo 'selected'; ?>>courant</option>
        </select>

        <div>
            <label for="ville">Choisissez votre ville:</label>
            <select id="ville" name="ville" required>
                <?php
                $sql = "SELECT * FROM ville";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["ville"] . "' " . ($row["ville"] == $ville ? 'selected' : '') . ">" . $row["ville"] . "</option>";
                    }
                } 
                ?>
            </select>
        </div>
        
        <button type="submit">Mettre à jour</button>
        <a href="liste.php" class="back-button">Retour à la liste</a>
    </form>
</body>
</html>

<?php
$conn->close();
?>
