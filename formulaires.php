<?php 
session_start(); // Démarre la session
include('session.php'); // Inclut la session contenant le pseudo
include("CoDB.php"); // Connexion à la BDD

// Vérification de la session et du pseudo
if (isset($Pseudo)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Vérifie que les champs sont bien remplis
        if (!empty($_POST['version']) && !empty($_POST['caracter']) && !empty($_POST['valeur'])) {
            $version = $_POST['version'];
            $caracter = $_POST['caracter'];
            $valeur = $_POST['valeur'];

            // Récupération du pseudo du joueur
            $trainer = $Pseudo; 

            // Débogage : afficher les valeurs avant l'insertion
            var_dump($version, $caracter, $valeur, $trainer);

            // Requête SQL pour insérer les données dans la table `caracters`
            $sql = "INSERT INTO caracters (version_en, name_en, valeur, Trainer) VALUES (?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssis", $version, $caracter, $valeur, $trainer); // "ssis" : string, string, int, string
                if ($stmt->execute()) {
                    echo '<div class="alert alert-success">Les données ont été enregistrées avec succès !</div>';
                } else {
                    echo '<div class="alert alert-danger">Erreur lors de l\'enregistrement.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Erreur dans la préparation de la requête SQL.</div>';
            }
        } else {
            echo '<div class="alert alert-warning">Veuillez remplir tous les champs.</div>';
        }
    }
} else {
    echo '<div class="alert alert-warning">Vous devez être connecté pour soumettre des données.</div>';
}

echo "Pseudo récupéré : " . htmlspecialchars($Pseudo);

?>



 

<!doctype html>
<html lang="fr" class="h-100" data-bs-theme="auto">
<head>
    <link rel="icon" type="image/vnd.icon" href="IMG/URLogo.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>馬レボリューション</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="CSS/connexion.css" rel="stylesheet">
</head>
<body class="h-100 text-center text-bg-dark"> 
<div class="cover-container header d-flex w-100 p-3 mx-auto flex-column">
  <header class="mb-auto">
    <div>
    <img class="logo" src="IMG/URLogo.png" alt="Logo">
      <h3 class="float-md-start mb-0">馬レボリューション</h3>
      <nav class="nav nav-masthead justify-content-center float-md-end">
        <a class="nav-link fw-bold py-1 px-0" href="index.php">Accueil</a>
        <a class="nav-link fw-bold py-1 px-0" href="pantheon.php">Panthéon</a>
        <a class="nav-link fw-bold py-1 px-0" href="ressources.php">Ressources</a>
        <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="formulaires.php">Formulaires</a>
       
      </nav>
    </div>
</header>

<main class="px-5">
	 <?php if (isset($Pseudo)): ?>
        <div class="alert alert-info">
            Bienvenue, <?= htmlspecialchars($Pseudo); ?> !
            <form method="post" style="display:inline;">
                <button type="submit" name="logout" class="btn btn-danger btn-sm">Déconnexion</button>
            </form>
        </div>
        <?php endif; ?>
<img class="mb-4" src="IMG/Tazuna.png" alt="" width="100" height="100">
<h1 class="h3 mb-3 fw-normal">Mise à jour des valeurs</h1>
<form method="post" action="">
    <label for="version_select">Sélectionnez la version :</label>
    <select class="form-select mb-3" name="version_select" onchange="this.form.submit()">
        <option value="">Choisir une version</option>
        <?php foreach ($versions as $version): ?>
            <option value="<?= htmlspecialchars($version['version_en']) ?>" <?= (isset($selected_version) && $selected_version == $version['version_en']) ? 'selected' : '' ?>><?= htmlspecialchars($version['version_en']) ?></option>
        <?php endforeach; ?>
    </select>
</form>

<?php if (!empty($caracters)): ?>
<form method="post" action="">
    <input type="hidden" name="version" value="<?= htmlspecialchars($selected_version) ?>">
    <label for="caracter">Personnage :</label>
    <select class="form-select mb-3" name="caracter" required>
        <?php foreach ($caracters as $caracter): ?>
            <option value="<?= htmlspecialchars($caracter['name_en']) ?>"><?= htmlspecialchars($caracter['name_en']) ?></option>
        <?php endforeach; ?>
    </select>
    <label for="valeur">Nouvelle valeur :</label>
    <input type="number" class="form-control mb-3" name="valeur" required>
    <button type="submit" class="btn btn-primary">Soumettre</button>
</form>
<?php endif; ?>
</main>
</div>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
