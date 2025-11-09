<?php
use PHPUnit\Framework\TestCase;
use App\Database;
use App\Produit;
use App\StockManager;

class StockManagerTest extends TestCase
{
        protected function setUp(): void
    {
        Database::getConnection()->exec("DELETE FROM produits");
    }

    public function test_total_stock()
    {
        $sm = new StockManager();
        $sm->ajouterProduit(new Produit("Stylo", 1000, 2));
        $sm->ajouterProduit(new Produit("Crayon", 500, 4));
        $this->assertEquals(1000*2 + 500*4, $sm->totalStock());
    }
}

?>