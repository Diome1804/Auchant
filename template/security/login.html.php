<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Connexion' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0f1a0a 0%, #1a2b13 50%, #0f1a0a 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Titre -->
        <div class="text-center mb-8">
            <div class="mb-4">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-lime-400 mb-4">
                    <svg class="w-8 h-8 text-[#0f1a0a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Auchant</h1>
            <p class="text-gray-400 text-lg">Welcome</p>
        </div>

        <!-- Formulaire de connexion -->
        <div class="bg-[#151f11] rounded-xl shadow-2xl p-8 border border-[#263a1d] backdrop-blur-sm">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">Connexion</h2>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6 animate-pulse">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="/login" class="space-y-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-300 text-sm font-medium mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                        Adresse email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        class="w-full bg-[#0f1a0a] border border-[#263a1d] rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-lime-400 focus:ring-2 focus:ring-lime-400/50 transition duration-200"
                        placeholder="admin@ndanan.com"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    >
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-gray-300 text-sm font-medium mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Mot de passe
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full bg-[#0f1a0a] border border-[#263a1d] rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-lime-400 focus:ring-2 focus:ring-lime-400/50 transition duration-200"
                        placeholder="••••••••"
                    >
                </div>

                <!-- Se souvenir de moi -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember"
                            class="w-4 h-4 text-lime-400 bg-[#0f1a0a] border-[#263a1d] rounded focus:ring-lime-400 focus:ring-2"
                        >
                        <label for="remember" class="ml-2 text-sm text-gray-300">
                            Se souvenir de moi
                        </label>
                    </div>
                    <a href="#" class="text-sm text-lime-400 hover:text-lime-300 transition">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Bouton de connexion -->
                <button 
                    type="submit"
                    class="w-full bg-lime-400 hover:bg-lime-500 text-[#0f1a0a] font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-lime-400 focus:ring-offset-2 focus:ring-offset-[#151f11]"
                >
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Se connecter
                </button>
            </form>

            <!-- Informations de test -->
            <div class="mt-6 p-4 bg-[#0f1a0a] rounded-lg border border-[#263a1d]">
                <div class="flex items-center mb-2">
                    <svg class="w-4 h-4 text-lime-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-sm font-medium text-lime-400">Compte de test :</h3>
                </div>
                <div class="pl-6">
                    <p class="text-xs text-gray-400 mb-1">
                        <span class="font-medium">Email:</span> admin@ndanan.com
                    </p>
                    <p class="text-xs text-gray-400">
                        <span class="font-medium">Mot de passe:</span> admin123
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-500 text-sm">
                © 2024 Le Ndanan du code. Tous droits réservés.
            </p>
            <div class="flex justify-center space-x-4 mt-2">
                <a href="#" class="text-gray-600 hover:text-lime-400 text-xs transition">Conditions d'utilisation</a>
                <span class="text-gray-600 text-xs">•</span>
                <a href="#" class="text-gray-600 hover:text-lime-400 text-xs transition">Politique de confidentialité</a>
            </div>
        </div>
    </div>

    <!-- Animation de fond -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -right-32 w-80 h-80 bg-lime-400/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-32 w-80 h-80 bg-lime-400/5 rounded-full blur-3xl"></div>
    </div>
</body>
</html>