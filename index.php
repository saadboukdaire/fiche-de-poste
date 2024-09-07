<?php $page = 'home';include 'header.php'; ?>

    <div class="container">

      <div class="starter-template">
      <h1 id="header">Fiche de poste</h1>
      </div>

    </div>
<?php
include("database.php");
$poste_query = "SELECT id_poste, Titre_poste FROM postes";
$postes = $conn->query($poste_query);

$competence_query = "SELECT DISTINCT id_competences, Nom_competences FROM competences";
$competences = $conn->query($competence_query);

$languages = array(
  'fr' => 'Francais',
  'ang' => 'Anglais',
  'ar' => 'Arabe'
);

$levels = array(
  'Debutant' => 'Debutant',
  'Intermediaire' => 'Intermediaire',
  'Courant' => 'Courant'
);

$job_competencies = array(
 
  "Développeur Web" => ["HTML", "CSS", "JS", "PHP", "MySQL", "Python", "Java", "C#", "C++", "Ruby", "Swift", "TypeScript", "React", "Angular", "Vue.js", "Node.js", "Express.js", "Laravel", "Django", "MongoDB", "PostgreSQL", "Git", "Docker", "Kubernetes", "AWS", "Azure", "Google Cloud", "UX/UI Design", "RESTful APIs", "Server management"],
  "Développeur Front-end" => ["HTML", "CSS", "JS", "TypeScript", "React", "Angular", "Vue.js", "UX/UI Design", "Cross-browser compatibility", "Wireframing", "Prototyping", "Interaction design"],
  "Développeur Back-end" => ["PHP", "MySQL", "Python", "Java", "C#", "C++", "Ruby", "Node.js", "Express.js", "Laravel", "Django", "MongoDB", "PostgreSQL", "Git", "Docker", "Kubernetes", "AWS", "Azure", "Google Cloud", "RESTful APIs", "Server management"],
  "Développeur Full Stack" => ["HTML", "CSS", "JS", "PHP", "MySQL", "Python", "Java", "C#", "C++", "Ruby", "Swift", "TypeScript", "React", "Angular", "Vue.js", "Node.js", "Express.js", "Laravel", "Django", "MongoDB", "PostgreSQL", "Git", "Docker", "Kubernetes", "AWS", "Azure", "Google Cloud", "UX/UI Design", "RESTful APIs", "Server management"],
  "Développeur Mobile" => ["Java", "Swift", "Kotlin", "Objective-C", "Mobile UI/UX design", "API integration", "React Native", "Flutter"],
  "Ingénieur logiciel" => ["Software development lifecycle (SDLC)", "Object-oriented programming (OOP)", "Design patterns", "Testing/debugging", "System design", "Microservices architecture", "Security", "Coding and scripting"],
  "Architecte logiciel" => ["Software development lifecycle (SDLC)", "Object-oriented programming (OOP)", "Design patterns", "System design", "Microservices architecture", "Scalability", "Security", "Coding and scripting", "Data analysis"],
  "Analyste programmeur" => ["Software development lifecycle (SDLC)", "Object-oriented programming (OOP)", "Design patterns", "Testing/debugging", "Data analysis"],
  "Administrateur système" => ["Linux/Windows Server", "Scripting (Bash, PowerShell)", "System monitoring", "Virtualization", "Backup and recovery"],
  "Administrateur réseau" => ["Network protocols (TCP/IP, DNS, DHCP)", "Routing and switching", "Network security", "Firewall configuration", "VPN"],
  "Ingénieur DevOps" => ["Continuous integration/continuous deployment (CI/CD)", "Containerization", "Infrastructure as Code (IaC)", "Monitoring tools (Prometheus, Grafana)", "Automation (Ansible, Puppet, Chef)"],
  "Spécialiste en sécurité informatique" => ["Risk assessment", "Vulnerability assessment", "Penetration testing", "Incident response", "Security protocols (SSL/TLS, SSH)", "Threat analysis", "Security monitoring", "Malware analysis", "Network security", "Compliance and regulations"],
  "Analyste en cybersécurité" => ["Risk assessment", "Vulnerability assessment", "Penetration testing", "Incident response", "Security protocols (SSL/TLS, SSH)", "Threat analysis", "Security monitoring", "Malware analysis", "Network security", "Compliance and regulations"],
  "Chef de projet informatique" => ["Project management methodologies (Agile, Scrum, Waterfall)", "Risk management", "Budget management", "Stakeholder communication", "Scheduling", "IT strategy"],
  "Consultant en informatique" => ["Business analysis", "Solution design", "Technical expertise", "Client management"],
  "Designer UX/UI" => ["User research", "Wireframing", "Prototyping", "Interaction design", "Usability testing"],
  "Intégrateur web" => ["HTML", "CSS", "JS", "Cross-browser compatibility", "SEO basics"],
  "Technicien support informatique" => ["Troubleshooting", "Technical support", "Customer service", "Hardware/software maintenance"],
  "Ingénieur cloud" => ["Cloud architecture", "Security and compliance", "Scalability", "Cost management"],
  "Analyste de données" => ["Data analysis", "Data visualization", "Statistical analysis", "Data warehousing"],
  "Expert en Big Data" => ["Hadoop ecosystem", "Spark", "Data mining", "Machine learning"],
  "Analyste QA (Assurance qualité)" => ["Test planning", "Manual testing", "Automated testing", "Bug tracking", "Quality standards"],
  "Analyste fonctionnel" => ["Requirements analysis", "Business process modeling", "Use case development", "System integration", "User acceptance testing"],
  "Analyste métier" => ["Requirements analysis", "Business process modeling", "Use case development", "System integration", "User acceptance testing"],  
  "Développeur de jeux vidéo" => ["Game engines (Unity, Unreal Engine)", "3D modeling", "Animation", "Game physics", "Scripting"],
  "Administrateur de bases de données" => ["Database design", "Performance tuning", "Backup and recovery", "Security management"],
  "Architecte cloud" => ["Cloud architecture design", "Migration strategies", "Security and compliance", "Cost optimization"],
  "Développeur blockchain" => ["Blockchain fundamentals", "Smart contracts (Solidity)", "Distributed ledger technology", "Cryptography", "Decentralized applications (dApps)"],
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clever council</title>
  <link rel ="stylesheet" href="assets/css/saad.css">
  <link rel="icon" type="image/png" href="assets/images/cleverrr.png">
  <script>
    const jobCompetencies = <?php echo json_encode($job_competencies); ?>;
  </script>
</head>
<body>
 
  
  
    
  
   <form action="index.php" method="post">
   <div class="container">
        <div>
          <label for="poste">Titre de poste</label>
          <select id="poste" name="poste" required onchange="updateCompetencies()">
            <?php
            if ($postes->num_rows > 0) {
                while ($poste = $postes->fetch_assoc()) {
                    echo "<option value='" . $poste["Titre_poste"] . "'>" . $poste["Titre_poste"] . "</option>";
                }
            } else {
                echo "<option value=''>No Job Titles Available</option>";
            }
            ?>
          </select>
        </div>
      
        <br> 
        <div>
          <label for="desc">Donner une description sur le poste :</label>
          <textarea id="desc" name="desc" rows="2" cols="30" maxlength="300" required></textarea>
        </div>
        <br>

        <div>
          <label for="ed">Niveau d'education</label>
          <select id="ed" name="ed">
            <option value="2">bac+2</option>
            <option value="3">bac+3(licence)</option>
            <option value="5">bac+5(Master)</option>
          </select>
        </div>
        <br>
      
        <div>
          <label for="exp">Années d'experience</label>
          <input type="number" id="exp" name="exp" min="0" max="40" value="0" required>
        </div>
        <br>
        <div>
          <label for="competences">Vos competences:</label><br>
          <div id="competences-container" class="competences-grid">
          <?php
if ($competences->num_rows > 0) {
  while ($competence = $competences->fetch_assoc()) {
    error_log("Competence fetched: " . json_encode($competence));
      echo "<div class='competence-item' data-name='" . $competence["Nom_competences"] . "'>";
      echo "<input type='checkbox' id='" . $competence["Nom_competences"] . "' name='competences[]' value='" . $competence["Nom_competences"] . "'>";
      echo "<label for='" . $competence["Nom_competences"] . "'>" . $competence["Nom_competences"] . "</label>";
      echo "</div>";
  }
} else {
  echo "No competences available.";
}
?>


      </div>

          </div>
          <br>
          <br>
          <br>
          <br>
          <div>
            <label>Vos niveaux de langue:</label><br>
            <?php foreach ($languages as $key => $language): ?>
              <label for="<?=$key; ?>"><?= $language; ?></label>
              <select id="<?= $key; ?>" name="<?= $key; ?>">
                <?php foreach ($levels as $value => $label): ?>
                  <option value="<?=$value; ?>"><?= $label; ?></option>
                <?php endforeach; ?>
              </select><br><br>
            <?php endforeach; ?>
          </div>
          <br>
          
          <div>
            <label for="ville">Choisissez votre ville:</label>
            <select id="ville" name="ville" required>
              <?php
              $sql = "SELECT * FROM ville";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row["ville"] . "'>" . $row["ville"] . "</option>";
                  }
              } 
              ?>
            </select>
          </div>

          <br>
          <button type="reset">reset</button>

          <button type="submit">submit</button>
          
          </div>
  </form>

  <script>
   function updateCompetencies() {
  const selectedPoste = document.getElementById("poste").value;
  const competenciesContainer = document.getElementById("competences-container");
  const competencyItems = competenciesContainer.getElementsByClassName("competence-item");
  const relevantCompetencies = jobCompetencies[selectedPoste] || [];


  for (let item of competencyItems) {
    item.style.display = "none";
  }

 
  relevantCompetencies.forEach(comp => {
    for (let item of competencyItems) {
      if (item.dataset.name === comp) {
        item.style.display = "block";
      }
    }
  });
}

    
    document.addEventListener("DOMContentLoaded", updateCompetencies);
    
  </script>

</body>
</html>

<?php


$errors = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $poste = isset($_POST["poste"]) ? $_POST["poste"] : '';
    if (empty($poste)) {
        $errors[] = "Titre de poste est requis.";
    }

   
    $desc = isset($_POST["desc"]) ? $_POST["desc"] : '';
    if (empty($desc)) {
        $errors[] = "Description est requise.";
    }

   
    $ed = isset($_POST["ed"]) ? $_POST["ed"] : '';
    if (!in_array($ed, ['2', '3', '5']) || $ed == 2 ) {
        $errors[] = "Vous devez au moins avoire une licence.";
    }

    
    $exp = isset($_POST["exp"]) ? $_POST["exp"] : '';
    if (!is_numeric($exp) || $exp < 0 || $exp > 40 ||$exp < 2) {
        $errors[] = "Vous devez avoire au moins 2 ans d'éxperience.";
    }

   
    $comp = isset($_POST['competences']) && is_array($_POST['competences']) ? $_POST['competences'] : [];
if (empty($comp)) {
    $errors[] = "Vous devez sélectionner au moins une compétence.";
} else {
    
    $comp_str = implode(', ', array_map([$conn, 'real_escape_string'], $comp));
}

    
    $fr = isset($_POST["fr"]) ? $_POST["fr"] : '';
    $ang = isset($_POST["ang"]) ? $_POST["ang"] : '';
    $ar = isset($_POST["ar"]) ? $_POST["ar"] : '';
    
    $ville = isset($_POST["ville"]) ? $_POST["ville"] : '';
    if (empty($ville)) {
        $errors[] = "La ville est requise.";
    }

 
    if (empty($errors)) {  
      $conn = mysqli_connect($servername, $username, $password, $dbname);

        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $poste = mysqli_real_escape_string($conn, $poste);
        if (!$postes) {
          die('Error fetching job titles: ' . $conn->error);
      }
      
        $desc = mysqli_real_escape_string($conn, $desc);
        $comp = implode(', ', array_map([$conn, 'real_escape_string'], $comp));

       
        $sql = "INSERT INTO fiche_pst (Titre_poste, Description, Niveau_education, Experience, Competences, Francais, Anglais, Arabe, Ville, date_creation) 
                VALUES ('$poste', '$desc', '$ed', '$exp', '$comp', '$fr', '$ang', '$ar', '$ville', NOW())";

        if (mysqli_query($conn, $sql)) {
            
           
           
            exit;
        } else {
            echo "Erreur lors de l'insertion dans fiche_pst: " . mysqli_error($conn) . "<br>";
        }
      
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
  mysqli_close($conn);
} else {
  
  foreach ($errors as $error) {
      echo '<script>alert("' . $error . '")</script>';
  }
}
}
?>