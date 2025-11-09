<?php
    namespace App;
    class StockManager
    {
        public function ajouterProduit(Produit $produit) : void{
            $produit ->save();
        }

        public function getProduits():array
        {
            return Produit::all();
        }

        public function getProduit(int $id):?Produit{
            return Produit::find($id);
        }
        public function supprimerProduit(int $id):void{
            Produit::delete($id);
        }
        public function totalStock():float
        {
            $total=0;
            foreach(Produit::all()as $p)
            {
                $total+=$p->getPrix()*$p->getQuantite();
            }
            return$total;
        }
    }
    
    


?>