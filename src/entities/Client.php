<?php

namespace App\Entity;


class Client extends Personne {
    private string $telephone;
    private array $commandes = [];


    public function __construct(string $telephone) {
        parent::__construct($id, $nom, $prenom,TypeEnum::CLIENT);
        $this->telephone = $telephone;
    }

    
    public static function toObject(array $data): static
    {
        $client = parent::toObject($data);
        $client->commandes = $data['commandes'] ?? [];
        $client->telephone = $data['telephone'] ?? '';
        return $client;
    }

    public function toArray(object $object): array
    
    {
            $data = parent::toArray();
            $data['telephone'] = $this->telephone;
            $data['commandes'] = array_map(function (Commande $commande) {
                return $commande->toArray();
            }, $this->commandes);
        return $data;
    }
    


    
}
