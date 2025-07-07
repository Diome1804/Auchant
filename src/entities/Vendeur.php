<?php
namespace App\Entity;


class Vendeur extends Personne
{        
    private string $login;
    private string $password;
    private array $commandes = [];
    private array $paiement = [];

    public function __construct(int $id, string $login, string $password)
    {
        parent::__construct($id, '', '', TypeEnum::VENDEUR);
        $this->login = $login;
        $this->password = $password;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    

     public static function toObject(array $data): static
    {
        $vendeur = parent::toObject($data);
        $vendeur->login = $data['login'] ?? '';
        $vendeur->password = $data['password'] ?? '';
        $vendeur->commandes = $data['commandes'] ?? [];
        $vendeur->paiement = $data['paiement'] ?? [];
        
        return $vendeur;
    }

    public function toArray(object $object): array
    
    {
            $data = parent::toArray();
            $data['commandes'] = array_map(function (Commande $commande) {
                return $commande->toArray();
            }, $this->commandes);
        return $data;
    }

    

    
}