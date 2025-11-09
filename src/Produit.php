<?php

namespace App;

use App\Database;
use Exception;

class Produit
{
    private ?int $id;
    private string $nom;
    private float $prix;
    private int $quantite;

    public function __construct(string $nom, float $prix, int $quantite = 0, ?int $id = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrix(): float { return $this->prix; }
    public function getQuantite(): int { return $this->quantite; }

    public function ajouterStock(int $quantite): void
    {
        if ($quantite < 0) throw new Exception("Quantité invalide");
        $this->quantite += $quantite;
    }

    public function retirerStock(int $quantite):void
    {
        if($quantite >$this->quantite) throw new Exception("Stock insufissant");
        $this->quantite=-$quantite;
    }
    
    public function save(): void {
    $pdo = Database::getTestConnection();

    if ($this->id) {
       
        $stmt = $pdo->prepare("UPDATE produits SET nom=?, prix=?, quantite=? WHERE id=?");
        $stmt->execute([$this->nom, $this->prix, $this->quantite, $this->id]);
    } else {
        
        $stmt = $pdo->prepare("INSERT INTO produits(nom, prix, quantite) VALUES (?, ?, ?)");
        $stmt->execute([$this->nom, $this->prix, $this->quantite]);
        $this->id = (int)$pdo->lastInsertId();
    }
}

    
    public static function all():array{
        $pdo = Database::getTestConnection();
        $stmt = $pdo->query("SELECT*FROM produits");
        $result=[];
        while($row=$stmt->fetch()){
                $result[]=new self($row['nom'],(float)$row['prix'],(int)$row['quantite'],(int)$row['id']);
            }
            return $result;
    }
    public static function find(int $id):?self 
    {
        $pdo = Database::getTestConnection();
        $stmt =$pdo->prepare("SELECT*FROM produits WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if(!$row)return null;
        return new self($row['nom'],(float)$row['prix'],(int)$row['quantite'],(int)$row['id']);
    }

    
    public static function delete(int $id):void{
        $pdo= Database::getTestConnection();
        $stmt = $pdo->prepare("DELETE FROM produits WHERE id=?");   
        $stmt->execute([$id]);
    }

}

?>