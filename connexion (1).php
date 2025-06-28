<?php
session_start();
include("CoDB.php");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM membres WHERE Pseudo = :Pseudo");
    $stmt->bindParam(':Pseudo', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['Pseudo'] = $user['Pseudo'];
        header("Location: indexadm.php");
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Uma Revolution - Connexion</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">

  <!-- Navbar -->
  <nav class="fixed w-full z-50 backdrop-blur bg-black/0">
    <div class="flex h-16 items-center justify-center max-w-7xl mx-auto px-4">
      <div class="hidden sm:flex space-x-2 items-center">
        <img class="h-8 w-auto" src="logo/URLogo.png" alt="Logo" />
        <a href="index.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
        <a href="pantheon.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Panthéon</a>
        <a href="ressources.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Ressources</a>
        <a href="connexion.php" class="text-white bg-gray-900 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
      </div>
      <div class="sm:hidden flex items-center justify-between w-full px-4">
        <img class="h-8 w-auto" src="logo/URLogo.png" alt="Logo" />
        <button onclick="toggleMobileMenu()" class="text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded-md">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
    <div id="mobile-menu" class="sm:hidden hidden px-2 pt-2 pb-3 space-y-1 text-center bg-gray-800 bg-opacity-80">
      <a href="index.php" class="block text-gray-300 hover:text-white hover:bg-gray-600 px-3 py-2 rounded-md">Accueil</a>
      <a href="pantheon.php" class="block text-gray-300 hover:text-white hover:bg-gray-600 px-3 py-2 rounded-md">Panthéon</a>
      <a href="ressources.php" class="block text-gray-300 hover:text-white hover:bg-gray-600 px-3 py-2 rounded-md">Ressources</a>
      <a href="connexion.php" class="block text-white bg-gray-900 px-3 py-2 rounded-md">Connexion</a>
    </div>
  </nav>

  <!-- Page de connexion -->
  <main class="relative flex items-center justify-center min-h-screen pt-20 px-4 bg-cover bg-center" id="cover">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>
    <div class="relative z-10 bg-white text-gray-800 rounded-xl shadow-lg p-6 sm:p-8 w-full max-w-md">
      <div class="flex justify-center mb-6">
        <img src="logo/Tazuna.png" alt="Tazuna" class="w-32 sm:w-40">
      </div>
      <h2 class="text-xl sm:text-2xl font-bold text-center mb-6">Connexion à votre compte</h2>

      <?php if (!empty($error)) : ?>
        <p class="text-red-600 text-center mb-4"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form action="connexion.php" method="POST" class="space-y-4">
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Pseudo</label>
          <input type="text" name="username" id="username" required
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
          <input type="password" name="password" id="password" required
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit"
          class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">Connexion</button>
      </form>
    </div>
  </main>

  <script>
    function toggleMobileMenu() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    }
  </script>

</body>
</html>
