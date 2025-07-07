<?php

namespace App\Controller;

use App\Config\Core\AbstractController;
use App\Entity\Personne;
use App\config\core;
use App\Service\SecurityService;
use App\core\Session;
use App\Config\Core\Validator;

class SecurityController extends AbstractController
{
    private SecurityService $securityService;
    private Session $session;

    public function __construct(){
        $this->securityService = new SecurityService();
        $this->session = Session::getInstance();
    }

    public function index()
    {
        if ($this->session->has('user_authenticated') && $this->session->get('user_authenticated') === true) {
            header('Location: /list');
            exit;
        }

        $this->renderHtmlLogin('security/login.html.php', [
            'showNavbar' => false,
            'title' => 'Connexion',
            'errors' => [],
            'old_input' => []
        ]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            Validator::clearErrors();
            
            $login = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            
            error_log("Login attempt: " . $login);
            error_log("Password length: " . strlen($password));

            
            $loginValid = true;
            $passwordValid = true;

            
            if (Validator::isEmpty($login, 'email')) {
                $loginValid = false;
                error_log("Email is empty");
            } else {
                
                if (!Validator::isEmail($login)) {
                    $loginValid = false;
                    error_log("Email is invalid");
                }
            }

            if (Validator::isEmpty($password, 'mot de passe')) {
                $passwordValid = false;
                error_log("Password is empty");
            } else {
                // Vérifier la longueur minimale du mot de passe
                if (!Validator::minLength($password, 6, 'mot de passe')) {
                    $passwordValid = false;
                    error_log("Password too short");
                }
            }

            
            $errors = Validator::getErrors();
            error_log("Validation errors: " . print_r($errors, true));

            if ($loginValid && $passwordValid) {
                $vendeur = $this->securityService->seConnecter($login, $password);

                if (!$vendeur) {
                    Validator::addError('credentials', 'Login ou mot de passe incorrect');
                    $errors = Validator::getErrors(); // Récupérer les erreurs mises à jour
                }
            }

            // Si tout est valide, connecter l'utilisateur
            if (Validator::isValid() && isset($vendeur) && $vendeur) {
                $this->session->regenerateId(true);
                $this->session->set('user_authenticated', true);

                if (method_exists($vendeur, 'getId')) {
                    $this->session->set('user_id', $vendeur->getId());
                }

                if (method_exists($vendeur, 'getEmail')) {
                    $this->session->set('user_email', $vendeur->getEmail());
                } elseif (method_exists($vendeur, 'getLogin')) {
                    $this->session->set('user_email', $vendeur->getLogin());
                } elseif (method_exists($vendeur, 'getMail')) {
                    $this->session->set('user_email', $vendeur->getMail());
                } else {
                    $this->session->set('user_email', $login);
                }

                if (method_exists($vendeur, 'getNom')) {
                    $this->session->set('user_nom', $vendeur->getNom());
                }

                if (method_exists($vendeur, 'getPrenom')) {
                    $this->session->set('user_prenom', $vendeur->getPrenom());
                }

                $this->session->set('user_login_time', time());

                $userData = ['login' => $login];

                if (method_exists($vendeur, 'getId')) {
                    $userData['id'] = $vendeur->getId();
                }
                if (method_exists($vendeur, 'getNom')) {
                    $userData['nom'] = $vendeur->getNom();
                }
                if (method_exists($vendeur, 'getPrenom')) {
                    $userData['prenom'] = $vendeur->getPrenom();
                }
                if (method_exists($vendeur, 'getEmail')) {
                    $userData['email'] = $vendeur->getEmail();
                } elseif (method_exists($vendeur, 'getLogin')) {
                    $userData['email'] = $vendeur->getLogin();
                } elseif (method_exists($vendeur, 'getMail')) {
                    $userData['email'] = $vendeur->getMail();
                }

                $this->session->set('user_data', $userData);
                $this->session->set('flash_success', 'Connexion réussie !');

                header('Location: /list');
                exit;
            } else {
                error_log("Rendering login with errors: " . print_r($errors, true));
                
                $this->renderHtmlLogin('security/login.html.php', [
                    'showNavbar' => false,
                    'title' => 'Connexion',
                    'errors' => $errors,
                    'old_input' => ['email' => $login]
                ]);
                return;
            }
        } else {
            
            $this->renderHtmlLogin('security/login.html.php', [
                'showNavbar' => false,
                'title' => 'Connexion',
                'errors' => [],
                'old_input' => []
            ]);
        }
    }

    public function logout()
    {
        $this->session->set('flash_info', 'Vous avez été déconnecté avec succès.');
        $this->session->unset('user_authenticated');
        $this->session->unset('user_id');
        $this->session->unset('user_email');
        $this->session->unset('user_nom');
        $this->session->unset('user_prenom');
        $this->session->unset('user_login_time');
        $this->session->unset('user_data');
        $this->session->regenerateId(true);

        header('Location: /login');
        exit;
    }

    public function isAuthenticated(): bool
    {
        return $this->session->has('user_authenticated') && 
               $this->session->get('user_authenticated') === true;
    }

    public function getCurrentUser(): ?array
    {
        if ($this->isAuthenticated()) {
            return $this->session->get('user_data');
        }
        return null;
    }

    public function getCurrentUserId(): ?int
    {
        if ($this->isAuthenticated()) {
            return $this->session->get('user_id');
        }
        return null;
    }

    public function isSessionExpired(int $maxLifetime = 3600): bool
    {
        if (!$this->session->has('user_login_time')) {
            return true;
        }

        $loginTime = $this->session->get('user_login_time');
        return (time() - $loginTime) > $maxLifetime;
    }

    public function requireAuth(): void
    {
        if (!$this->isAuthenticated() || $this->isSessionExpired()) {
            $this->session->set('flash_warning', 'Vous devez être connecté pour accéder à cette page.');
            header('Location: /login');
            exit;
        }
    }

    public function store() {}
    public function create() {}
    public function destroy() {}
    public function show() {}
    public function edit() {}
}
