<?php

namespace App\Repository;
use App\Entity\Personne;
use App\Entity\Client;
use App\Entity\Vendeur;
use App\Config\Core\Database;
use App\Config\Core\AbstractRepository;

class PersonneRepository extends AbstractRepository{

    protected \PDO $pdo;

    private static ?PersonneRepository $instance = null;

    private function __construct() {
        $this->pdo = Database::getConnection();
    }

    public static function getInstance(): PersonneRepository
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
    
    public function getTableName(): string
    {
        return 'personne';
    }

    public function selectByLoginAndPassword(string $login, string $password): ?Vendeur
    {
        $stmt = $this->pdo->prepare("SELECT * FROM personne WHERE login = :login AND password = :password ");
        $stmt->execute(['login' => $login, 'password' => $password]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        // var_dump($row);
        // die();

        if ($row) {
            // Vérifier si l'utilisateur est un vendeur
            if ($row['type'] === 'Vendeur') {
                return Vendeur::toObject($row);
            }
        }

        return null;
    }

    /**
     * Trouve les personnes par nom
     */
    public function findByNom(string $nom): array
    {
        try {
            $sql = "SELECT * FROM " . $this->getTableName() . " WHERE nom ILIKE :nom";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nom', "%$nom%");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la recherche par nom : " . $e->getMessage());
        }
    }

    /**
     * Trouve les personnes par prénom
     */
    public function findByPrenom(string $prenom): array
    {
        try {
            $sql = "SELECT * FROM " . $this->getTableName() . " WHERE prenom ILIKE :prenom";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':prenom', "%$prenom%");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la recherche par prénom : " . $e->getMessage());
        }
    }

    /**
     * Trouve les personnes par nom complet
     */
    public function findByNomComplet(string $nom, string $prenom): array
    {
        try {
            $sql = "SELECT * FROM " . $this->getTableName() . " WHERE nom ILIKE :nom AND prenom ILIKE :prenom";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nom', "%$nom%");
            $stmt->bindValue(':prenom', "%$prenom%");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la recherche par nom complet : " . $e->getMessage());
        }
    }

    /**
     * Trouve les personnes par téléphone
     */
    public function findByTelephone(string $telephone): ?array
    {
        try {
            $sql = "SELECT * FROM " . $this->getTableName() . " WHERE telephone = :telephone";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->execute();
            
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la recherche par téléphone : " . $e->getMessage());
        }
    }

    /**
     * Trouve les personnes par âge
     */
    public function findByAge(int $age): array
    {
        try {
            $sql = "SELECT * FROM " . $this->getTableName() . " WHERE age = :age";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':age', $age, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la recherche par âge : " . $e->getMessage());
        }
    }

    /**
     * Trouve les personnes dans une tranche d'âge
     */
    public function findByAgeRange(int $ageMin, int $ageMax): array
    {
        try {
            $sql = "SELECT * FROM " . $this->getTableName() . " WHERE age BETWEEN :age_min AND :age_max";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':age_min', $ageMin, \PDO::PARAM_INT);
            $stmt->bindParam(':age_max', $ageMax, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la recherche par tranche d'âge : " . $e->getMessage());
        }
    }

    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        try {
            $sql = "SELECT 1 FROM " . $this->getTableName() . " WHERE email = :email";
            $params = [':email' => $email];
            
            if ($excludeId !== null) {
                $sql .= " AND " . $this->getPrimaryKey() . " != :exclude_id";
                $params[':exclude_id'] = $excludeId;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn() !== false;
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la vérification de l'email : " . $e->getMessage());
        }
    }

    /**
     * Vérifie si un téléphone existe déjà
     */
    public function telephoneExists(string $telephone, ?int $excludeId = null): bool
    {
        try {
            $sql = "SELECT 1 FROM " . $this->getTableName() . " WHERE telephone = :telephone";
            $params = [':telephone' => $telephone];
            
            if ($excludeId !== null) {
                $sql .= " AND " . $this->getPrimaryKey() . " != :exclude_id";
                $params[':exclude_id'] = $excludeId;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn() !== false;
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la vérification du téléphone : " . $e->getMessage());
        }
    }

    /**
     * Recherche globale dans les personnes
     */
    public function search(string $term): array
    {
        try {
            $sql = "SELECT * FROM " . $this->getTableName() . " 
                    WHERE nom ILIKE :term 
                    OR prenom ILIKE :term 
                    OR email ILIKE :term 
                    OR telephone ILIKE :term";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':term', "%$term%");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la recherche : " . $e->getMessage());
        }
    }

    /**
     * Récupère les personnes avec pagination
     */
    public function findWithPagination(int $limit = 10, int $offset = 0): array
    {
        try {
            $sql = "SELECT * FROM " . $this->getTableName() . " 
                    ORDER BY nom, prenom 
                    LIMIT :limit OFFSET :offset";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la pagination : " . $e->getMessage());
        }
    }
}
