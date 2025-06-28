<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>馬レボリューション</title>
  <link rel="icon" href="IMG/URLogo.png" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('IMG/background.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
  </style>
</head>
<body class="bg-gray-900 text-white">

  <!-- Navbar transparente et centrée -->
  <nav class="fixed w-full z-50 backdrop-blur bg-black/0">
    <div class="flex h-16 items-center justify-center max-w-7xl mx-auto px-4">
      <!-- Desktop menu centré -->
      <div class="hidden sm:flex space-x-2 items-center">
        <img class="h-8 w-auto" src="logo/URLogo.png" alt="Logo" />
        <a href="indexadm.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
        <a href="pantheonadm.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Panthéon</a>
        <a href="ressourcesadm.php" class="text-gray-300 hover:text-white hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Ressources</a>
        <a href="formulaires.php" class="text-white bg-gray-900 px-3 py-2 rounded-md text-sm font-medium">Formulaires</a>
      </div>

      <!-- Logo + menu mobile -->
      <div class="sm:hidden flex items-center justify-between w-full px-4">
        <img class="h-8 w-auto" src="logo/URLogo.png" alt="Logo" />
        <button onclick="toggleMobileMenu()" class="text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white" aria-label="Toggle menu">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Menu mobile déroulant -->
    <div id="mobile-menu" class="sm:hidden hidden px-2 pt-2 pb-3 space-y-1 text-center bg-gray-800 bg-opacity-80">
      <a href="index.php" class="block text-gray-300 hover:text-white hover:bg-gray-600 px-3 py-2 rounded-md text-base font-medium">Accueil</a>
      <a href="pantheon.php" class="block text-gray-300 hover:text-white hover:bg-gray-600 px-3 py-2 rounded-md text-base font-medium">Panthéon</a>
      <a href="ressources.php" class="block text-gray-300 hover:text-white hover:bg-gray-600 px-3 py-2 rounded-md text-base font-medium">Ressources</a>
      <a href="connexion.php" class="block text-white bg-gray-900 px-3 py-2 rounded-md text-base font-medium">Connexion</a>
    </div>
  </nav>

  <!-- Main content -->
  <main class="pt-32 px-6 max-w-7xl mx-auto">
    <h2 class="text-4xl font-bold text-center mb-12">📚 Ressources indispensables</h2>

    <!-- First row -->
    <div class="grid md:grid-cols-3 gap-6">
      <div class="bg-purple-800/70 p-6 rounded-xl hover:scale-105 transition-transform text-center">
        <img src="IMG/TL.png" alt="Tier List" class="mx-auto mb-4 rounded">
        <h3 class="text-xl font-semibold mb-2">Tier List cartes support</h3>
        <p class="mb-4">Consulte les meilleures cartes pour optimiser tes entraînements.</p>
        <a href="https://gamewith.jp/uma-musume/article/show/258925" target="_blank" class="inline-block px-4 py-2 border border-white rounded hover:bg-white hover:text-black transition">Voir la tier list</a>
      </div>

      <div class="bg-purple-800/70 p-6 rounded-xl hover:scale-105 transition-transform text-center">
        <img src="IMG/gametora.png" alt="Gametora" class="mx-auto mb-4 rounded">
        <h3 class="text-xl font-semibold mb-2">Gametora</h3>
        <p class="mb-4">Simulateur, guides et bases de données pour t’aider au quotidien.</p>
        <a href="https://gametora.com/umamusume" target="_blank" class="inline-block px-4 py-2 border border-white rounded hover:bg-white hover:text-black transition">Aller sur Gametora</a>
      </div>

      <div class="bg-purple-800/70 p-6 rounded-xl hover:scale-105 transition-transform text-center">
        <img src="IMG/GFF.png" alt="Twinkle Legends" class="mx-auto mb-4 rounded">
        <h3 class="text-xl font-semibold mb-2">Twinkle Legends</h3>
        <p class="mb-4">Le Google Doc du dernier scénario avec plein d’infos utiles.</p>
        <a href="https://docs.google.com/document/u/0/d/1v9w4Tr48Xh5mXWHSLGGUU_XEYY148t7wqPd9120QjBU/mobilebasic" target="_blank" class="inline-block px-4 py-2 border border-white rounded hover:bg-white hover:text-black transition">Lire le guide</a>
      </div>
    </div>

    <hr class="my-12 border-white/30">

    <!-- Second row -->
    <div class="grid md:grid-cols-2 gap-6">
      <div class="bg-purple-800/70 p-6 rounded-xl hover:scale-105 transition-transform">
        <h3 class="text-xl font-semibold mb-2">Ressources variées</h3>
        <p class="mb-4">Site regroupant diverses ressources visuelles.</p>
        <a href="https://xn--gck1f423k.xn--1bvt37a.tools/supports/rankings/friendship" target="_blank" class="inline-block px-4 py-2 border border-white rounded hover:bg-white hover:text-black transition">Consulter les ressources</a>
      </div>

      <div class="bg-purple-800/70 p-6 rounded-xl hover:scale-105 transition-transform">
        <h3 class="text-xl font-semibold mb-2">UmaPure DB</h3>
        <p class="mb-4">Un outil pour rechercher les meilleurs parents selon tes besoins.</p>
        <a href="https://uma.pure-db.com/#/search" target="_blank" class="inline-block px-4 py-2 border border-white rounded hover:bg-white hover:text-black transition">Chercher un parent</a>
      </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mt-6">
      <div class="bg-purple-800/70 p-6 rounded-xl hover:scale-105 transition-transform">
        <h3 class="text-xl font-semibold mb-2">Calculateur de score</h3>
        <p class="mb-4">Un outil pour calculer la note de fin en fonction des skills.</p>
        <a href="https://gamewith.jp/uma-musume/article/show/279309" target="_blank" class="inline-block px-4 py-2 border border-white rounded hover:bg-white hover:text-black transition">Calculatrice de score</a>
      </div>

      <div class="bg-purple-800/70 p-6 rounded-xl hover:scale-105 transition-transform">
        <h3 class="text-xl font-semibold mb-2">Uma ma ma ma</h3>
        <p class="mb-4">Un outil pour faire parler GoldShip si tu te sens seul…</p>
        <a href="https://huggingface.co/spaces/Plachta/VITS-Umamusume-voice-synthesizer" target="_blank" class="inline-block px-4 py-2 border border-white rounded hover:bg-white hover:text-black transition">Parler avec GoldShip</a>
      </div>
    </div>
  </main>
</body>
</html>
