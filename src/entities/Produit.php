<?php

namespace App\Entity;


class Produit extends AbstractEntity {
    private int $id;
    private float $prix;
    private int $qteStock;

    public function __construct(int $id, float $prix, int $qteStock) {
        $this->id = $id;
        $this->prix = $prix;
        $this->qteStock = $qteStock;
    }
    
          public static function toObject(array $tableau): static
    {
        return new static(
            $tableau['id'] ?? 0,
            $tableau['nom'] ?? '',
            $tableau['prenom'] ?? '',
            $tableau['telephone'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'telephone' => $this->telephone,
            'type' => Type::Client->name
        ];
    }
}
