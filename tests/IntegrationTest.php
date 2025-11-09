<?php
use PHPUnit\Framework\TestCase;
use App\Produit;
use App\StockManager;
use App\Database;

class IntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        $pdo = Database::getTestConnection();
        $pdo->exec("DELETE FROM produits");
    }

    public function test_ajout_et_retrieval_produit()
    {
        $sm = new StockManager();

// Ajouter un produit
        $produit = new Produit("Gomme", 300, 3);
        $sm->ajouterProduit($produit);

// Récupérer le produit via StockManager
        $retrieved = $sm->getProduit($produit->getId());

        $this->assertNotNull($retrieved);
        $this->assertEquals("Gomme", $retrieved->getNom());
        $this->assertEquals(3, $retrieved->getQuantite());

// Vérifier totalStock
        $this->assertEquals(300*3, $sm->totalStock());
    }

    public function test_suppression_produit()
    {
        $sm = new StockManager();
        $p = new Produit("Stylo", 1000, 2);
        $sm->ajouterProduit($p);
        $sm->supprimerProduit($p->getId());
        $this->assertNull($sm->getProduit($p->getId()));
        $this->assertEquals(0, $sm->totalStock());
    }
}

?>