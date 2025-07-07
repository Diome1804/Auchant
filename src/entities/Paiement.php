<?php
namespace App\Entity;




class Paiement extends AbstractEntity {
    private int $id;
    private int $numero;
    private DateTime $date;
    private float $montantVerse;
    private Facture $facture;
    private Vendeur $vendeur;

    public function __construct(int $id, DateTime $date, float $montantVerse, Facture $facture, Vendeur $vendeur) {
        $this->id = $id;
        $this->date = $date;
        $this->montantVerse = $montantVerse;
        $this->facture = $facture;
        $this->vendeur = $vendeur;
    }

    public static function toObject(array $data): static
    {
        $paiement = parent::toObject($data);
        $paiement->numero = $data['numero'] ?? 0;
        $paiement->date = $data['date'] ?? new DateTime();
        $paiement->montantVerse = $data['montantVerse'] ?? 0;
        $paiement->facture = $data['facture'] ?? new Facture(0, 0, 0);
        $paiement->vendeur = $data['vendeur'] ?? new Vendeur(0, '', '');
        return $paiement;
    }

    public function toArray(): array
    {
            $data = parent::toArray();
            $data['numero'] = $this->numero;
            $data['date'] = $this->date->format('Y-m-d');
            $data['montantVerse'] = $this->montantVerse;
            $data['facture'] = $this->facture->toArray();
            $data['vendeur'] = $this->vendeur->toArray();
            // $data['commandes'] =array_map(function (Commande $commande) {
            //     return $commande->toArray();
            // }, $this->commandes);
        return $data;
    }


}
