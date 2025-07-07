<?php

namespace App\Service;
use App\Repository\PersonneRepository;
use App\Entity\Personne;

class SecurityService {

    private PersonneRepository $personneRepository;
    private static ?SecurityService $instance = null;

    private function __construct() {
        $this->personneRepository = PersonneRepository::getInstance();
    }

    public static function getInstance(): SecurityService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Empêcher le clonage
    private function __clone() {}

    // Empêcher la désérialisation
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }

    public function seConnecter(string $login, string $password): ?Personne{ 
        
        $Vendeur = $this->personneRepository->selectByLoginAndPassword($login, $password);

        // var_dump($Vendeur);
        // die();

        if ($Vendeur) {
            var_dump("in vendeur != null");
            return $Vendeur;
        }
        
        return null;
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function seDeconnecter(): void
    {
        session_start();
        session_destroy();
    }

    /**
     * Vérifie si un utilisateur est connecté
     */
    public function estConnecte(): bool
    {
        session_start();
        return isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true;
    }
}
