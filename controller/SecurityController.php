<?php

namespace App\Controller;

use App\Config\Core\AbstractController;
use App\Entity\Personne;
use App\config\core;
use App\Service\SecurityService;

class SecurityController extends AbstractController

    
    
    
{
    private SecurityService $securityService;

    public function __construct(){
        $this->securityService = new SecurityService();
    }

    public function index()
    {
        $this->renderHtmlLogin('security/login.html.php', [
            'showNavbar' => false,
            'title' => 'Connexion'
        ]);
    }


    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $vendeur = $this->securityService->seConnecter($login, $password);

        if ($vendeur) {
            // Générer un token (ici simplifié avec uniqid)
            $token = uniqid('token_', true);

            // Stocker ce token dans un cookie (durée 1 heure)
            setcookie('auth_token', $token, time() + 3600, '/');

            // Optionnel : associer ce token à l'utilisateur si besoin dans un tableau statique ou fichier

            header('Location: /list');
            exit;
        } else {
            $this->renderHtmlLogin('security/login.html.php', [
                'showNavbar' => false,
                'title' => 'Connexion',
                'error' => 'Login ou mot de passe incorrect'
            ]);
        }
    } else {
        $this->renderHtmlLogin('security/login.html.php', [
            'showNavbar' => false,
            'title' => 'Connexion',
            'error' => null
        ]);
    }
}


    public function logout()
    {
        // Supprimer le cookie auth_token
    setcookie('auth_token', '', time() - 3600, '/');

    // Rediriger vers la page de login
    header('Location: /login');
    exit;
    }

    public function store() {}
    public function create() {}
    public function destroy() {}
    public function show() {}
    public function edit() {}
}