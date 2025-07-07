<?php
namespace App\Repository;

use App\Entity\Produit;
use App\Config\Core\Database;

class ProduitRepository {

    private \PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Récupérer tous les produits
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM produit");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $produits = [];
        foreach ($rows as $row) {
            $produits[] = Produit::toObject($row);
        }

        return $produits;
    }

    // Récupérer un produit par ID
    public function findById(int $id): ?Produit {
        $stmt = $this->pdo->prepare("SELECT * FROM produit WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? Produit::toObject($row) : null;
    }

    // Insérer un nouveau produit
    public function insert(Produit $produit): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO produit (prix, quantite_stock)
            VALUES (:prix, :quantite_stock)
        ");

        $stmt->execute([
            'prix' => $produit->getPrix(),
            'quantite_stock' => $produit->getQteStock()
        ]);
        
    }

    // Mettre à jour un produit
    public function update(Produit $produit): void {
        $stmt = $this->pdo->prepare("
            UPDATE produit SET prix = :prix, quantite_stock = :quantite_stock
            WHERE id = :id
        ");

        $stmt->execute([
            'id' => $produit->getId(),
            'prix' => $produit->getPrix(),
            'quantite_stock' => $produit->getQteStock()
        ]);
    }

    // Supprimer un produit
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM produit WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}