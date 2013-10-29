<?php

class Orderline {
    
    public $product; // de te bestellen producten en aantallen
    public $amount;
    public $eenheidprijs;
    public $prijs; 
    public $artikelnummer;
   
    
    public function Orderline($product, $amount) {
        $this->product	=$product;
        $this->amount   =$amount;
      
    }

    public function tableRow() {
        $eenheidprijs = $this->product->getPrice();
        $eenheidprijs= number_format ($eenheidprijs , 2 , "," , "." );
        $prijs= $this->product->getPrice()*$this->amount;
        $prijs= number_format ($prijs , 2 , "," , "." );
        $artikelnummer= $this->product->getProductID();
        // $PHP_SELF = $_SERVER['PHP_SELF'];
       
        return "<tr>
                    <td>".$this->product->getName()."</td>
                    <td>".$this->amount."</td>
                    <td>".$eenheidprijs."</td>
                    <td>".$prijs."</td>
                    <td>
                    <a href=".$_SERVER['PHP_SELF']."?DEL=".$artikelnummer.">verwijder</a></td></tr>";
        
    }
    
    public function totaalPrijs() {
        return $this->product->getPrijs()*$this->amount;
    }
    
    public function orderRow() {
        $eenheidprijs = $this->product->getPrice();
        $eenheidprijs= number_format ($eenheidprijs , 2 , "," , "." );
        $prijs= $this->product->getPrice()*$this->amount;
        $prijs= number_format ($prijs , 2 , "," , "." );
        $artikelnummer= $this->product->getProductID();
        // $PHP_SELF = $_SERVER['PHP_SELF'];
       
        return "<tr>
                    <td>".$this->product->getName()."</td>
                    <td>".$this->amount."</td>
                    <td>".$eenheidprijs."</td>
                    <td>".$prijs."</td>";
                    
         
        
    }

    //put your code here
}

?>
