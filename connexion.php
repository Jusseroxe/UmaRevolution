<?php
include('session.php');
include("CoDB.php");
try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification des données du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';  // Utilise 'username' pour correspondre au champ HTML
    $password = $_POST['password'] ?? '';

    // Requête pour récupérer l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM membres WHERE Pseudo = :Pseudo");
    $stmt->bindParam(':Pseudo', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Authentification réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['Pseudo'] = $user['Pseudo'];
        header("Location: indexadm.php"); // Redirection vers la page d'accueil
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
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
    <div class="cover-container d-flex w-100 h-50 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div>
                <img class="logo" src="IMG/URLogo.png" alt="Logo">
                <h3 class="float-md-start mb-0">馬レボリューション</h3>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link fw-bold py-1 px-0" href="index.php">Accueil</a>
                    <a class="nav-link fw-bold py-1 px-0" href="pantheon.php">Panthéon</a>
                    <a class="nav-link fw-bold py-1 px-0" href="ressources.php">Ressources</a>
                    <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="connexion.php">Connexion</a>
                </nav>
            </div>
        </header>


        <main class="px-5">

<img class="mb-4" src="IMG/Tazuna.png" alt="" width="100" height="100">
<h1 class="h3 mb-3 fw-normal">Connecte-toi !</h1>



    
    <?php if (!empty($error)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
    <div class="form-floating">
                    <input type="text" class="form-control" id="username" placeholder="Pseudo" name="username" required>
                    <label for="pseudo">Pseudo</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="password" required>
                    <label for="password">Mot de passe :</label>
                </div>
        
                <button class="btn btn-primary w-100 py-2" type="submit" name="Connection">Se connecter</button>    </form>
    </main>  
    </div>



    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
