<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("CoDB.php"); // Connexion BDD
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Uma Revolution - Panthéon</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>#cover { transition: background-image 1s ease-in-out; }</style>
  <script>
    function toggleMobileMenu() {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    }
  </script>
</head>
<body class="bg-gray-900 text-white">
<nav class="fixed w-full z-50 backdrop-blur bg-black/0">
  <div class="flex h-16 items-center justify-center max-w-7xl mx-auto px-4">
    <div class="hidden sm:flex space-x-2 items-center">
      <img class="h-8 w-auto" src="logo/URLogo.png" alt="Logo" />
      <a href="index.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
      <a href="pantheon.php" class="text-white bg-gray-900 px-3 py-2 rounded-md text-sm font-medium">Panthéon</a>
      <a href="ressources.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Ressources</a>
      <a href="connexion.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
    </div>
  </div>
</nav>

<main class="pt-24 px-4 max-w-7xl mx-auto">
  <h1 class="text-4xl font-bold text-center mb-10">Panthéon</h1>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Cartes des personnages -->
    <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php
      if (isset($objet_PDO)) {
        try {
          $sql = "SELECT char_id, card_id, name_en, trainer, trainer_glo, version_en, valeur, valeur_glo FROM caracters";
          $stmt = $objet_PDO->prepare($sql);
          $stmt->execute();
          $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if ($characters && count($characters) > 0) {
            foreach ($characters as $char) {
              $char_id     = htmlspecialchars((string)($char['char_id'] ?? ''));
              $card_id     = htmlspecialchars((string)($char['card_id'] ?? ''));
              $name_en     = htmlspecialchars((string)($char['name_en'] ?? ''));
              $trainer     = htmlspecialchars((string)($char['trainer'] ?? 'Inconnu'));
              $trainer_glo = htmlspecialchars((string)($char['trainer_glo'] ?? 'Inconnu'));
              $version     = htmlspecialchars((string)($char['version_en'] ?? ''));
              $valeur      = htmlspecialchars((string)($char['valeur'] ?? '0'));
              $valeur_glo  = htmlspecialchars((string)($char['valeur_glo'] ?? '0'));
              $image_url   = "https://gametora.com/images/umamusume/characters/chara_stand_{$char_id}_{$card_id}.png";

              echo '<div class="bg-gray-800 p-4 rounded-lg text-center">';
              echo "<img src='$image_url' alt='$name_en' class='mx-auto w-32 h-auto mb-3'>";
              echo "<h3 class='text-xl font-semibold'>$name_en</h3>";
              echo "<p class='text-sm mt-2'>
                      Entraîneur : $trainer<br>
                      Score : $valeur<br>
                      Global Trainer : $trainer_glo<br>
                      Score global : $valeur_glo<br>
                      Version : $version
                    </p>";
              echo '</div>';
            }
          } else {
            echo '<p class="text-red-400 col-span-3">Aucun personnage trouvé.</p>';
          }
        } catch (PDOException $e) {
          echo '<p class="text-red-500 col-span-3">Erreur BDD : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
      } else {
        echo '<p class="text-red-500 col-span-3">Connexion BDD non établie.</p>';
      }
      ?>
    </div>

    <!-- Classement entraîneurs -->
    <div class="bg-gray-800 p-4 rounded-lg space-y-8">
      <div>
        <h2 class="text-2xl font-semibold mb-4">Classement des entraîneurs</h2>
        <table class="w-full text-left">
          <thead>
            <tr>
              <th class="border-b border-gray-600 pb-2">Trainer</th>
              <th class="border-b border-gray-600 pb-2">Apparitions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            try {
              $sql = "SELECT trainer, COUNT(*) AS nb FROM caracters WHERE trainer IS NOT NULL AND trainer != '' GROUP BY trainer ORDER BY nb DESC";
              $stmt = $objet_PDO->prepare($sql);
              $stmt->execute();
              $trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($trainers as $row) {
                $pseudo = htmlspecialchars($row['trainer']);
                $count  = htmlspecialchars($row['nb']);
                echo "<tr class='border-b border-gray-700'><td class='py-2'>$pseudo</td><td class='py-2'>$count</td></tr>";
              }
            } catch (PDOException $e) {
              echo "<tr><td colspan='2' class='text-red-500'>Erreur : " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <div>
        <h2 class="text-2xl font-semibold mb-4">Classement global des entraîneurs</h2>
        <table class="w-full text-left">
          <thead>
            <tr>
              <th class="border-b border-gray-600 pb-2">Trainer Glo</th>
              <th class="border-b border-gray-600 pb-2">Apparitions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            try {
              $sql = "SELECT trainer_glo, COUNT(*) AS nb FROM caracters WHERE trainer_glo IS NOT NULL AND trainer_glo != '' GROUP BY trainer_glo ORDER BY nb DESC";
              $stmt = $objet_PDO->prepare($sql);
              $stmt->execute();
              $trainers_glo = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($trainers_glo as $row) {
                $pseudo = htmlspecialchars($row['trainer_glo']);
                $count  = htmlspecialchars($row['nb']);
                echo "<tr class='border-b border-gray-700'><td class='py-2'>$pseudo</td><td class='py-2'>$count</td></tr>";
              }
            } catch (PDOException $e) {
              echo "<tr><td colspan='2' class='text-red-500'>Erreur : " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>
</body>
</html>
