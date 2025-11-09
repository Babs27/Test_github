<?php
use PHPUnit\Framework\TestCase;
use App\Database;
use App\Produit;

class ProduitTest extends TestCase
{
    protected function setUp(): void
    {   
        Database::getTestConnection()->exec("DELETE FROM produits");
    }

    public function test_creation_produit()
    {
        $p = new Produit("Stylo", 1000, 5);
        $p->save();

        $this->assertNotNull($p->getId());
        $this->assertEquals("Stylo", $p->getNom());
        $this->assertEquals(5, $p->getQuantite());
    }

    public function test_ajout_stock()
    {
        $p = new Produit("Crayon", 500, 10);
        $p->ajouterStock(5);
        $this->assertEquals(15, $p->getQuantite());
    }
}

?>