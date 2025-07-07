<?php
namespace App\Entity;

class Commande extends AbstractEntity {
    private int $id;
    private DateTime $date;
    private Client $client;
    private array $produits = [];
    private Vendeur $vendeur ;



    public function __construct(int $id, DateTime $date, Client $client, array $produits, array $factures) {
        $this->id = $id;
        $this->date = $date;
        $this->client = $client;
        $this->produits = $produits;
    }

    public function getId(): int {
        return $this->id;
    }
    public function getDate(): DateTime {
        return $this->date;
    }
    public function getClient(): Client {
        return $this->client;
    }
    public function getProduits(): array {
        return $this->produits;
    }
    public function addProduit(Produit $produit): void {
        $this->produits[] = $produit;
    }
    public function getVendeur(): Vendeur {
        return $this->vendeur;
    }

}
  

