<?php
use PHPUnit\Framework\TestCase;
use App\Produit;
use App\StockManager;
use App\Database;

class AcceptanceTest extends TestCase
{
protected function setUp(): void
{
Database::getTestConnection()->exec("DELETE FROM produits");
}

public function test_workflow_complet()
{
$sm = new StockManager();

// 1️ Ajouter produit

$p1 = new Produit("Cahier", 1500, 5);
$sm->ajouterProduit($p1);

$this->assertEquals(1500*5, $sm->totalStock());

// 2️ Ajouter un autre produit
$p2 = new Produit("Crayon", 500, 10);
$sm->ajouterProduit($p2);

$this->assertEquals(1500*5 + 500*10, $sm->totalStock());

// 3️ Modifier stock
$p1->ajouterStock(5);
$p1->save();

$this->assertEquals(1500*10 + 500*10, $sm->totalStock());

// 4️ Supprimer un produit
$sm->supprimerProduit($p2->getId());
$this->assertEquals(1500*10, $sm->totalStock());
}
}

?>