<?php

namespace App\Entity;
use App\Config\Core\AbstractEntity;

abstract class Personne extends AbstractEntity
{

    protected int $id;
    protected string $nom;
    protected string $prenom;
    protected TypeEnum $type;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    public function __construct(int $id = 0 , string $nom = '',string $prenom = '', TypeEnum $type = TypeEnum::VENDEUR)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->type = $type;
    }
    public function getType(): TypeEnum
    {
        return $this->type;
    }
    public function setType(TypeEnum $type): void
    {
        $this->type = $type;
    }

          public static function toObject(array $tableau): static
    {
        return new static(
            $tableau['id'] ?? 0,
            $tableau['nom'] ?? '',
            $tableau['prenom'] ?? '',
            $tableau['type'] ?? '',
        );
    }

    public function toArray(object $object): array
    //public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'type' => $this->type

        ];
    }


}
