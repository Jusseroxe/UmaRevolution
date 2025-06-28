<?php
session_start();
include('session.php');
include("CoDB.php");

if (!isset($_SESSION['Pseudo'])) {
    $error = "Vous devez être connecté pour accéder à cette page.";
} else {
    $Pseudo = $_SESSION['Pseudo'];

    // Déconnexion
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        header("Location: connexion.php");
        exit();
    }

    // Soumission du formulaire principal
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valeur_type'])) {
        $version = $_POST['version'] ?? '';
        $caracter = $_POST['caracter'] ?? '';
        $valeur = $_POST['valeur'] ?? '';
        $valeur_type = in_array($_POST['valeur_type'], ['valeur', 'valeur_glo']) ? $_POST['valeur_type'] : 'valeur';
        $trainer_col = ($valeur_type === 'valeur_glo') ? 'Trainer_glo' : 'Trainer';

        if (!empty($version) && !empty($caracter) && $valeur !== '') {
            $sql = "INSERT INTO caracters (version_en, name_en, $valeur_type, $trainer_col)
                    VALUES (:version, :caracter, :valeur, :trainer)
                    ON DUPLICATE KEY UPDATE $valeur_type = :valeur, $trainer_col = :trainer";

            $stmt = $objet_PDO->prepare($sql);
            $stmt->execute([
                'version' => $version,
                'caracter' => $caracter,
                'valeur' => $valeur,
                'trainer' => $Pseudo
            ]);

            $message = "Valeur mise à jour avec succès.";
            $message_type = "success";
        } else {
            $message = "Tous les champs doivent être remplis.";
            $message_type = "error";
        }
    }

    // Chargement des versions disponibles
    $versions = $objet_PDO->query("SELECT DISTINCT version_en FROM caracters ORDER BY version_en ASC")->fetchAll(PDO::FETCH_ASSOC);
    $caracters = [];

    // Si une version est sélectionnée, charger les personnages associés
    if (isset($_POST['version_select']) && $_POST['version_select']) {
        $selected_version = $_POST['version_select'];
        $stmt = $objet_PDO->prepare("SELECT DISTINCT name_en FROM caracters WHERE version_en = ?");
        $stmt->execute([$selected_version]);
        $caracters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaires - Uma Revolution</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <nav class="fixed w-full z-50 backdrop-blur bg-black/0">
        <div class="flex h-16 items-center justify-center max-w-7xl mx-auto px-4">
            <div class="hidden sm:flex space-x-2 items-center">
                <img class="h-8" src="logo/URLogo.png" alt="Logo" />
                <a href="indexadm.php" class="text-gray-300 hover:text-white px-3 py-2">Accueil</a>
                <a href="pantheonadm.php" class="text-gray-300 hover:text-white px-3 py-2">Panthéon</a>
                <a href="ressourcesadm.php" class="text-gray-300 hover:text-white px-3 py-2">Ressources</a>
                <a href="formulaires.php" class="text-white bg-gray-900 px-3 py-2 rounded-md">Formulaires</a>
            </div>
        </div>
    </nav>

    <main class="pt-24 px-4 max-w-2xl mx-auto">
        <?php if (isset($Pseudo)): ?>
            <div class="bg-gray-800 p-4 rounded-lg mb-4 flex items-center justify-between">
                <p>Bienvenue, <strong><?= htmlspecialchars($Pseudo) ?></strong></p>
                <form method="post">
                    <button type="submit" name="logout" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded">Déconnexion</button>
                </form>
            </div>

            <?php if (isset($message)): ?>
                <div class="p-3 mb-4 rounded <?= $message_type === 'success' ? 'bg-green-500' : 'bg-red-500' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire de sélection de version -->
            <form method="post" class="mb-6">
                <label class="block mb-1">Sélectionnez la version :</label>
                <select name="version_select" onchange="this.form.submit()" class="w-full p-2 rounded bg-gray-700 text-white mb-4">
                    <option value="">-- Choisir une version --</option>
                    <?php foreach ($versions as $version): ?>
                        <option value="<?= htmlspecialchars($version['version_en']) ?>" <?= (isset($selected_version) && $selected_version === $version['version_en']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($version['version_en']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <!-- Formulaire principal -->
            <?php if (!empty($caracters)): ?>
                <form method="post" class="bg-gray-800 p-6 rounded-lg space-y-4">
                    <input type="hidden" name="version" value="<?= htmlspecialchars($selected_version) ?>">

                    <div>
                        <label class="block mb-1">Personnage :</label>
                        <select name="caracter" class="w-full p-2 rounded bg-gray-700 text-white">
                            <?php foreach ($caracters as $caracter): ?>
                                <option value="<?= htmlspecialchars($caracter['name_en']) ?>"><?= htmlspecialchars($caracter['name_en']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1">Type de valeur :</label>
                        <select name="valeur_type" class="w-full p-2 rounded bg-gray-700 text-white" required>
                            <option value="valeur">Valeur</option>
                            <option value="valeur_glo">Valeur globale</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1">Valeur numérique :</label>
                        <input type="number" name="valeur" class="w-full p-2 rounded bg-gray-700 text-white" required>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-2 rounded text-white font-semibold">Soumettre</button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <div class="bg-yellow-500 text-black p-4 rounded-lg">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
