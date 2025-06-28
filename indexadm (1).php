<?php 
include('session.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Uma Revolution</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    #cover {
      transition: background-image 1s ease-in-out;
    }
  </style>
  <script>
    function toggleMobileMenu() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    }

    document.addEventListener("DOMContentLoaded", () => {
      const images = [
        "BackIndex/img1.png",
        "BackIndex/img2.png",
        "BackIndex/img3.png",
        "BackIndex/img4.png",
        "BackIndex/img5.png"
      ];
      let index = 0;
      const cover = document.getElementById('cover');

      // Set initial image
      cover.style.backgroundImage = `url('${images[0]}')`;

      function changeBackground() {
        index = (index + 1) % images.length;
        cover.style.backgroundImage = `url('${images[index]}')`;
      }

      setInterval(changeBackground, 5000);
    });
  </script>
</head>
<body class="bg-gray-900 text-white">

  <!-- Navbar transparente et centrée -->
  <nav class="fixed w-full z-50 backdrop-blur bg-black/0">
    <div class="flex h-16 items-center justify-center max-w-7xl mx-auto px-4">
      <!-- Desktop menu centré -->
      <div class="hidden sm:flex space-x-2 items-center">
        <img class="h-8 w-auto" src="logo/URLogo.png" alt="Logo" />
        <a href="indexadm.php" class="text-white bg-gray-900 px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
        <a href="pantheonadm.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Panthéon</a>
        <a href="ressourcesadm.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Ressources</a>
        <a href="formulaires.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Formulaires</a>
      </div>

      <!-- Logo + menu mobile -->
      <div class="sm:hidden flex items-center justify-between w-full">
        <img class="h-8 w-auto ml-4" src="logo/URLogo.png" alt="Logo" />
        <button onclick="toggleMobileMenu()" class="text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white mr-4" aria-label="Toggle menu">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Menu mobile déroulant -->
    <div id="mobile-menu" class="sm:hidden hidden px-2 pt-2 pb-3 space-y-1 text-center bg-gray-800 bg-opacity-80">
      <a href="index.php" class="block text-white bg-gray-900 px-3 py-2 rounded-md text-base font-medium">Accueil</a>
      <a href="pantheon.php" class="block text-gray-300 hover:text-white hover:bg-gray-600 px-3 py-2 rounded-md text-base font-medium">Panthéon</a>
      <a href="#" class="block text-gray-300 hover:text-white hover:bg-gray-600 px-3 py-2 rounded-md text-base font-medium">Ressources</a>
      <a href="connexion.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
    </div>
  </nav>

  <!-- Cover avec texte centré et fond dynamique -->
  <main id="cover" class="min-h-screen flex flex-col items-center justify-center text-center px-4 bg-cover bg-center bg-no-repeat pt-16 relative">
    <div class="absolute inset-0 bg-black opacity-60"></div>

    <div class="relative z-10 max-w-xl text-white px-4 sm:px-6 lg:px-8">
      <h1 class="text-3xl sm:text-5xl font-extrabold mb-4">Bienvenue <?= htmlspecialchars($_SESSION['Pseudo']) ?> sur Uma Revolution !</h1>
      <p class="text-sm sm:text-lg mb-8 whitespace-pre-line">
       Tu es bien connecté(e) sur 馬レボリューション. J'espère que tu n'a pas volé trop d'Uma !
      </p>
      <a href="formulaires.php" class="bg-indigo-600 hover:bg-indigo-700 font-semibold py-3 px-8 rounded-lg transition duration-300">
        Accès formulaires
      </a>
    </div>
  </main>

</body>
</html>
