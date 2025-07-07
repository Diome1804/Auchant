<?php
namespace App\Entity;



class ProduitCommande extends AbstractEntity {
    private Produit $produit;
    private Commande $commande;
    private int $qteCommande;
    private float $montant;

    public function __construct(Produit $produit, int $qteCommande) {
        $this->produit = $produit;
        $this->qteCommande = $qteCommande;
        $this->montant = $produit->getPrix() * $qteCommande;
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
