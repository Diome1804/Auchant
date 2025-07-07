<?php


namespace App\Service;
use App\Repository\PersonneRepository;
use App\Entity\Personne;

class SecurityService {



    private PersonneRepository $personneRepository;




    public function __construct() {
        $this->personneRepository = new PersonneRepository();
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


    
