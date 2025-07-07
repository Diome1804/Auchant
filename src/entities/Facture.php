<?php

namespace App\Entity;

class Facture  extends AbstractEntity {
    private int $id;
    private int $numero;
    private DateTime $date;
    private float $montant;
    private Commande $commande;
    private array $factures = [];

    public function __construct(int $id, DateTime $date, float $montant, float $montantRestant, Statut $statut, array $factures) {
        $this->id = $id;
        $this->date = $date;
        $this->montant = $montant;
        $this->montantRestant = $montantRestant;
        $this->statut = $statut;
        $this->commande = $commande;
    }

    public function getId(): int {
        return $this->id;
    }
    public function getDate(): DateTime {
        return $this->date;
    }
    public function getMontant(): float {
        return $this->montant;
    }




}
